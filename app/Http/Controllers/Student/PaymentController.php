<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\ClassModel;
use App\Models\Academic\Lesson;
use App\Models\Academic\LessonPayment;
use App\Models\Academic\MaterialPayment;
use App\Models\Academic\SubjectMaterial;
use App\Models\PaymentTransaction;
use App\Services\MarzPayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class PaymentController extends Controller
{
    public function __construct(protected MarzPayService $marzPay)
    {
    }

    // ──────────────────────────────────────────────────────────────────────────
    // INITIATE: Class Payment
    // ──────────────────────────────────────────────────────────────────────────
    public function initiateClassPayment(Request $request): JsonResponse
    {
        $request->validate([
            'class_id'       => 'required|exists:classes,id',
            'payment_method' => 'required|in:mtn,airtel,card',
            'phone_number'   => 'required_unless:payment_method,card|nullable|string|max:20',
            'amount'         => 'required|integer|min:500',
        ]);

        $studentId = session('LoggedStudent');

        if (!$studentId) {
            return response()->json(['success' => false, 'message' => 'Not authenticated.'], 401);
        }

        $enrollment = ClassEnrollment::where('class_id', $request->class_id)
            ->where('student_id', $studentId)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return response()->json(['success' => false, 'message' => 'Enrollment not found.'], 404);
        }

        if (strtolower($enrollment->payment_status) === 'paid') {
            return response()->json(['success' => false, 'message' => 'This class has already been paid for.'], 400);
        }

        $class = ClassModel::findOrFail($request->class_id);

        // ── Server-side price check ─────────────────────────────────────────
        // Never trust a client-supplied amount alone — validate against the
        // actual configured class fee, not just the UGX 500 floor.
        $requiredAmount = (int) config('marzpay.default_class_fee', 50000);

        if ((int) $request->amount < $requiredAmount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient amount. This class requires at least UGX ' . number_format($requiredAmount) . '.',
            ]);
        }

        $reference = (string) Uuid::uuid4();

        // Store the pending transaction
        $transaction = PaymentTransaction::create([
            'reference'    => $reference,
            'student_id'   => $studentId,
            'payment_type' => 'class',
            'payable_id'   => $request->class_id,
            'amount'       => $request->amount,
            'method'       => $request->payment_method,
            'phone_number' => $request->phone_number ?? null,
            'status'       => 'pending',
        ]);

        $description = "Class payment: {$class->name}";
        $callbackUrl = route('payment.webhook');

        // ── Card payment ──────────────────────────────────────────────────────
        if ($request->payment_method === 'card') {
            $result = $this->marzPay->collectCard(
                amount:      $request->amount,
                description: $description,
                callbackUrl: $callbackUrl,
                reference:   $reference,
            );

            if (!$result['success']) {
                $transaction->update(['status' => 'failed']);
                return response()->json(['success' => false, 'message' => $result['message']]);
            }

            $transaction->update([
                'marzpay_uuid' => $result['uuid'],
                'status'       => 'processing',
                'redirect_url' => $result['redirect_url'],
            ]);

            return response()->json([
                'success'      => true,
                'type'         => 'card_redirect',
                'redirect_url' => $result['redirect_url'],
                'message'      => 'Redirecting to card payment gateway…',
            ]);
        }

        // ── Mobile Money (MTN / Airtel) ───────────────────────────────────────
        $result = $this->marzPay->collectMobileMoney(
            amount:      $request->amount,
            phoneNumber: $request->phone_number,
            description: $description,
            callbackUrl: $callbackUrl,
            reference:   $reference,
        );

        if (!$result['success']) {
            $transaction->update(['status' => 'failed']);
            return response()->json(['success' => false, 'message' => $result['message']]);
        }

        $transaction->update([
            'marzpay_uuid' => $result['uuid'],
            'status'       => 'processing',
        ]);

        return response()->json([
            'success'   => true,
            'type'      => 'mobile_money',
            'reference' => $reference,
            'message'   => 'Payment request sent! Please check your phone and approve the prompt.',
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // INITIATE: Lesson Payment
    // ──────────────────────────────────────────────────────────────────────────
    public function initiateLessonPayment(Request $request): JsonResponse
    {
        $request->validate([
            'lesson_id'       => 'required|exists:lessons,id',
            'payment_method'  => 'required|in:mtn,airtel,card',
            'phone_number'    => 'required_unless:payment_method,card|nullable|string|max:20',
            'amount'          => 'required|integer|min:500',
        ]);

        $studentId = session('LoggedStudent');

        if (!$studentId) {
            return response()->json(['success' => false, 'message' => 'Not authenticated.'], 401);
        }

        $lesson = Lesson::findOrFail($request->lesson_id);

        // ── Server-side price check ─────────────────────────────────────────
        // Look up the lesson's real price from the database — never trust a
        // "required_amount" value submitted by the client alongside "amount".
        $requiredAmount = (int) str_replace(',', '', (string) $lesson->lesson_amount);

        if ((int) $request->amount < $requiredAmount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient amount. Required: UGX ' . number_format($requiredAmount),
            ]);
        }

        $reference = (string) Uuid::uuid4();

        $transaction = PaymentTransaction::create([
            'reference'    => $reference,
            'student_id'   => $studentId,
            'payment_type' => 'lesson',
            'payable_id'   => $request->lesson_id,
            'amount'       => $request->amount,
            'method'       => $request->payment_method,
            'phone_number' => $request->phone_number ?? null,
            'status'       => 'pending',
        ]);

        $description = "Lesson payment: {$lesson->title}";
        $callbackUrl = route('payment.webhook');

        // ── Card ──────────────────────────────────────────────────────────────
        if ($request->payment_method === 'card') {
            $result = $this->marzPay->collectCard(
                amount:      $request->amount,
                description: $description,
                callbackUrl: $callbackUrl,
                reference:   $reference,
            );

            if (!$result['success']) {
                $transaction->update(['status' => 'failed']);
                return response()->json(['success' => false, 'message' => $result['message']]);
            }

            $transaction->update([
                'marzpay_uuid' => $result['uuid'],
                'status'       => 'processing',
                'redirect_url' => $result['redirect_url'],
            ]);

            return response()->json([
                'success'      => true,
                'type'         => 'card_redirect',
                'redirect_url' => $result['redirect_url'],
                'message'      => 'Redirecting to card payment gateway…',
            ]);
        }

        // ── Mobile Money ──────────────────────────────────────────────────────
        $result = $this->marzPay->collectMobileMoney(
            amount:      $request->amount,
            phoneNumber: $request->phone_number,
            description: $description,
            callbackUrl: $callbackUrl,
            reference:   $reference,
        );

        if (!$result['success']) {
            $transaction->update(['status' => 'failed']);
            return response()->json(['success' => false, 'message' => $result['message']]);
        }

        $transaction->update([
            'marzpay_uuid' => $result['uuid'],
            'status'       => 'processing',
        ]);

        return response()->json([
            'success'   => true,
            'type'      => 'mobile_money',
            'reference' => $reference,
            'message'   => 'Payment request sent! Please check your phone and approve the prompt.',
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // INITIATE: Subject Material (PDF) Payment
    // ──────────────────────────────────────────────────────────────────────────
    public function initiateMaterialPayment(Request $request): JsonResponse
    {
        $request->validate([
            'material_id'     => 'required|exists:subject_materials,id',
            'payment_method'  => 'required|in:mtn,airtel,card',
            'phone_number'    => 'required_unless:payment_method,card|nullable|string|max:20',
            'amount'          => 'required|integer|min:500',
        ]);

        $studentId = session('LoggedStudent');

        if (!$studentId) {
            return response()->json(['success' => false, 'message' => 'Not authenticated.'], 401);
        }

        $material = SubjectMaterial::findOrFail($request->material_id);

        // ── Server-side price check ─────────────────────────────────────────
        // Look up the material's real price from the database — never trust a
        // "required_amount" value submitted by the client alongside "amount".
        $requiredAmount = (int) str_replace(',', '', (string) $material->amount);

        if ((int) $request->amount < $requiredAmount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient amount. Required: UGX ' . number_format($requiredAmount),
            ]);
        }

        $reference = (string) Uuid::uuid4();

        $transaction = PaymentTransaction::create([
            'reference'    => $reference,
            'student_id'   => $studentId,
            'payment_type' => 'material',
            'payable_id'   => $request->material_id,
            'amount'       => $request->amount,
            'method'       => $request->payment_method,
            'phone_number' => $request->phone_number ?? null,
            'status'       => 'pending',
        ]);

        $description = "Study material payment: {$material->title}";
        $callbackUrl = route('payment.webhook');

        // ── Card ──────────────────────────────────────────────────────────────
        if ($request->payment_method === 'card') {
            $result = $this->marzPay->collectCard(
                amount:      $request->amount,
                description: $description,
                callbackUrl: $callbackUrl,
                reference:   $reference,
            );

            if (!$result['success']) {
                $transaction->update(['status' => 'failed']);
                return response()->json(['success' => false, 'message' => $result['message']]);
            }

            $transaction->update([
                'marzpay_uuid' => $result['uuid'],
                'status'       => 'processing',
                'redirect_url' => $result['redirect_url'],
            ]);

            return response()->json([
                'success'      => true,
                'type'         => 'card_redirect',
                'redirect_url' => $result['redirect_url'],
                'message'      => 'Redirecting to card payment gateway…',
            ]);
        }

        // ── Mobile Money ──────────────────────────────────────────────────────
        $result = $this->marzPay->collectMobileMoney(
            amount:      $request->amount,
            phoneNumber: $request->phone_number,
            description: $description,
            callbackUrl: $callbackUrl,
            reference:   $reference,
        );

        if (!$result['success']) {
            $transaction->update(['status' => 'failed']);
            return response()->json(['success' => false, 'message' => $result['message']]);
        }

        $transaction->update([
            'marzpay_uuid' => $result['uuid'],
            'status'       => 'processing',
        ]);

        return response()->json([
            'success'   => true,
            'type'      => 'mobile_money',
            'reference' => $reference,
            'message'   => 'Payment request sent! Please check your phone and approve the prompt.',
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // WEBHOOK: MarzPay posts to this endpoint with final payment status
    // ──────────────────────────────────────────────────────────────────────────
    public function webhook(Request $request)
    {
        $payload = $request->all();
        Log::info('MarzPay webhook received', $payload);

        $eventType = $payload['event_type'] ?? null;
        $reference = $payload['transaction']['reference'] ?? null;

        if (!$reference) {
            return response()->json(['ok' => false, 'message' => 'Missing reference'], 400);
        }

        $transaction = PaymentTransaction::where('reference', $reference)->first();

        if (!$transaction) {
            Log::warning('MarzPay webhook: transaction not found', ['reference' => $reference]);
            return response()->json(['ok' => true]); // Acknowledge so MarzPay doesn't retry
        }

        // Already finalised — skip (idempotency)
        if (in_array($transaction->status, ['completed', 'failed', 'cancelled'])) {
            return response()->json(['ok' => true]);
        }

        $transaction->update([
            'webhook_payload'        => $payload,
            'provider_transaction_id' => $payload['collection']['provider_transaction_id'] ?? null,
        ]);

        if ($eventType === 'collection.completed') {
            $this->handleSuccessfulPayment($transaction);
        } else {
            // failed or cancelled
            $newStatus = str_contains($eventType ?? '', 'cancelled') ? 'cancelled' : 'failed';
            $transaction->update(['status' => $newStatus]);
        }

        return response()->json(['ok' => true]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // POLL: Student polls this after mobile money prompt to know if paid
    // ──────────────────────────────────────────────────────────────────────────
    public function checkStatus(Request $request): JsonResponse
    {
        $request->validate(['reference' => 'required|uuid']);

        $transaction = PaymentTransaction::where('reference', $request->reference)
            ->where('student_id', session('LoggedStudent'))
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'status'  => $transaction->status,
            'paid'    => $transaction->isCompleted(),
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // INTERNAL: Mark enrollment/lesson paid after webhook confirms success
    // ──────────────────────────────────────────────────────────────────────────
    protected function handleSuccessfulPayment(PaymentTransaction $transaction): void
    {
        $transaction->update(['status' => 'completed']);

        if ($transaction->payment_type === 'class') {
            ClassEnrollment::where('class_id', $transaction->payable_id)
                ->where('student_id', $transaction->student_id)
                ->where('status', 'active')
                ->update([
                    'payment_status' => 'paid',
                    'amount_paid'    => $transaction->amount,
                ]);
        } elseif ($transaction->payment_type === 'lesson') {
            // IMPORTANT: this must be scoped to THIS student only.
            // Writing to lessons.lesson_payment_status here would mark the
            // lesson "Paid" for every student, not just the one who paid.
            LessonPayment::updateOrCreate(
                [
                    'lesson_id'  => $transaction->payable_id,
                    'student_id' => $transaction->student_id,
                ],
                [
                    'payment_transaction_id' => $transaction->id,
                    'amount_paid'            => $transaction->amount,
                    'paid_at'                => now(),
                ]
            );
        } elseif ($transaction->payment_type === 'material') {
            // Same per-student scoping as lesson payments — one row per
            // student per material, never a global "paid" flag.
            MaterialPayment::updateOrCreate(
                [
                    'subject_material_id' => $transaction->payable_id,
                    'student_id'          => $transaction->student_id,
                ],
                [
                    'payment_transaction_id' => $transaction->id,
                    'amount_paid'            => $transaction->amount,
                    'paid_at'                => now(),
                ]
            );
        }

        Log::info('MarzPay payment applied', [
            'type'       => $transaction->payment_type,
            'payable_id' => $transaction->payable_id,
            'student_id' => $transaction->student_id,
            'amount'     => $transaction->amount,
        ]);
    }
}