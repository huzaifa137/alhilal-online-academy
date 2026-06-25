    <?php

    use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('class_subjects', function (Blueprint $table) {

            // Create separate index for class_id
            $table->index('class_id', 'class_subjects_class_id_index');
        });

        Schema::table('class_subjects', function (Blueprint $table) {

            // Now MySQL no longer needs the unique key for FK support
            $table->dropUnique('unique_class_subject_year');

            $table->unique(
                ['class_id', 'subject_id', 'academic_year_id', 'teacher_id'],
                'unique_class_subject_year_teacher'
            );
        });
    }

    public function down()
    {
        Schema::table('class_subjects', function (Blueprint $table) {

            $table->dropUnique('unique_class_subject_year_teacher');

            $table->unique(
                ['class_id', 'subject_id', 'academic_year_id'],
                'unique_class_subject_year'
            );

            $table->dropIndex('class_subjects_class_id_index');
        });
    }
};