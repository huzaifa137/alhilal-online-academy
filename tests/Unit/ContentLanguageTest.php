<?php

namespace Tests\Unit;

use App\Support\ContentLanguage;
use Tests\TestCase;

/**
 * Pure logic tests (no database): who may open content taught in which language.
 */
class ContentLanguageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['languages.content_lock' => true]);
        session()->flush();
    }

    public function test_luganda_is_a_supported_content_language(): void
    {
        $this->assertContains('lg', ContentLanguage::codes());
        $this->assertTrue(ContentLanguage::isValid('lg'));
        $this->assertFalse(ContentLanguage::isValid('xx'));
        $this->assertSame('Oluganda', ContentLanguage::native('lg'));
        $this->assertStringContainsString('lg', ContentLanguage::rule());
    }

    public function test_student_only_gets_content_in_the_selected_language(): void
    {
        session()->put('LoggedStudent', 1);

        app()->setLocale('sw');
        $this->assertTrue(ContentLanguage::allows('sw'));
        $this->assertFalse(ContentLanguage::allows('en'));
        $this->assertSame('sw', ContentLanguage::filterForCurrentUser());

        app()->setLocale('en');
        $this->assertTrue(ContentLanguage::allows('en'));
        $this->assertFalse(ContentLanguage::allows('sw'));
    }

    public function test_teachers_and_admins_are_never_restricted(): void
    {
        app()->setLocale('en');

        session()->put('LoggedTeacher', 5);
        $this->assertTrue(ContentLanguage::allows('lg'));
        $this->assertNull(ContentLanguage::filterForCurrentUser());

        session()->flush();
        session()->put('LoggedAdmin', 1);
        $this->assertTrue(ContentLanguage::allows('ar'));
    }

    public function test_lock_can_be_switched_off(): void
    {
        config(['languages.content_lock' => false]);
        session()->put('LoggedStudent', 1);
        app()->setLocale('en');

        $this->assertTrue(ContentLanguage::allows('sw'));
        $this->assertNull(ContentLanguage::viewerLanguage());
    }

    public function test_content_without_language_is_treated_as_default_language(): void
    {
        session()->put('LoggedStudent', 1);
        app()->setLocale(ContentLanguage::default());

        $this->assertTrue(ContentLanguage::allows(null));
    }
}
