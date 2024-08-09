<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("
            CREATE TRIGGER after_insert_trainings
            AFTER INSERT ON trainings
            FOR EACH ROW
            BEGIN
                INSERT INTO change_log (entity_type, entity_id, new_value, change_type, created_at, updated_at)
                VALUES (
                    'trainings',
                    NEW.nik,
                    CONCAT('Materi ID: ', NEW.materi_id, ', Tanggal: ', NEW.tanggal, ', First Score: ', NEW.first_score, ', Retest Score: ', NEW.retest_score),
                    'INSERT',
                    NOW(),
                    NOW()
                );
            END;
        ");
    
        DB::statement("
            CREATE TRIGGER after_update_trainings
            AFTER UPDATE ON trainings
            FOR EACH ROW
            BEGIN
                INSERT INTO change_log (entity_type, entity_id, old_value, new_value, change_type, created_at, updated_at)
                VALUES (
                    'trainings',
                    OLD.nik,
                    CONCAT('Materi ID: ', OLD.materi_id, ', Tanggal: ', OLD.tanggal, ', First Score: ', OLD.first_score, ', Retest Score: ', OLD.retest_score),
                    CONCAT('Materi ID: ', NEW.materi_id, ', Tanggal: ', NEW.tanggal, ', First Score: ', NEW.first_score, ', Retest Score: ', NEW.retest_score),
                    'UPDATE',
                    NOW(),
                    NOW()
                );
            END;
        ");
    
        DB::statement("
            CREATE TRIGGER after_delete_trainings
            AFTER DELETE ON trainings
            FOR EACH ROW
            BEGIN
                INSERT INTO change_log (entity_type, entity_id, old_value, change_type, created_at, updated_at)
                VALUES (
                    'trainings',
                    OLD.nik,
                    CONCAT('Materi ID: ', OLD.materi_id, ', Tanggal: ', OLD.tanggal, ', First Score: ', OLD.first_score, ', Retest Score: ', OLD.retest_score),
                    'DELETE',
                    NOW(),
                    NOW()
                );
            END;
        ");
    }
    
    public function down()
    {
        DB::statement("DROP TRIGGER IF EXISTS after_insert_trainings");
        DB::statement("DROP TRIGGER IF EXISTS after_update_trainings");
        DB::statement("DROP TRIGGER IF EXISTS after_delete_trainings");
    }
};
