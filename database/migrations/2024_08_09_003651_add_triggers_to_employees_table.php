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
            CREATE TRIGGER after_insert_employees
            AFTER INSERT ON employees
            FOR EACH ROW
            BEGIN
                INSERT INTO change_log (entity_type, entity_id, new_value, change_type, created_at, updated_at)
                VALUES (
                    'employee',
                    NEW.nik,
                    CONCAT('Name: ', NEW.name, ', Position: ', NEW.position, ', Building: ', NEW.building, ', Area: ', NEW.area, ', Cell ID: ', NEW.cell),
                    'INSERT',
                    NOW(),
                    NOW()
                );
            END;
        ");
    
        DB::statement("
            CREATE TRIGGER after_update_employees
            AFTER UPDATE ON employees
            FOR EACH ROW
            BEGIN
                INSERT INTO change_log (entity_type, entity_id, old_value, new_value, change_type, created_at, updated_at)
                VALUES (
                    'employee',
                    OLD.nik,
                    CONCAT('Name: ', OLD.name, ', Position: ', OLD.position, ', Building: ', OLD.building, ', Area: ', OLD.area, ', Cell ID: ', OLD.cell),
                    CONCAT('Name: ', NEW.name, ', Position: ', NEW.position, ', Building: ', NEW.building, ', Area: ', NEW.area, ', Cell ID: ', NEW.cell),
                    'UPDATE',
                    NOW(),
                    NOW()
                );
            END;
        ");
    
        DB::statement("
            CREATE TRIGGER after_delete_employees
            AFTER DELETE ON employees
            FOR EACH ROW
            BEGIN
                INSERT INTO change_log (entity_type, entity_id, old_value, change_type, created_at, updated_at)
                VALUES (
                    'employee',
                    OLD.nik,
                    CONCAT('Name: ', OLD.name, ', Position: ', OLD.position, ', Building: ', OLD.building, ', Area: ', OLD.area, ', Cell ID: ', OLD.cell),
                    'DELETE',
                    NOW(),
                    NOW()
                );
            END;
        ");
    }
    
    public function down()
    {
        DB::statement("DROP TRIGGER IF EXISTS after_insert_employees");
        DB::statement("DROP TRIGGER IF EXISTS after_update_employees");
        DB::statement("DROP TRIGGER IF EXISTS after_delete_employees");
    }
};
