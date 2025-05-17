<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE TRIGGER after_borrowing_approved_insert_into_used_items
            AFTER UPDATE ON borrowings
            FOR EACH ROW
            BEGIN
                DECLARE disposable INT;

                SELECT items.disposable INTO disposable
                FROM unit_items
                JOIN items ON unit_items.item_id = items.id
                WHERE unit_items.id = OLD.unit_id;

                IF NEW.status = 'approved' AND OLD.status = 'pending' AND disposable = 1 THEN
                    INSERT INTO used_items (
                        borrowing_id,
                        user_id,
                        description,
                        created_at,
                        updated_at
                    ) VALUES (
                        NEW.id,
                        NEW.user_id,
                        NEW.description,
                        NOW(),
                        NOW()
                    );
                END IF;
            END;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS after_borrowing_approved_insert_into_used_items");
    }
};
