<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNotificationsTableToMakeColumnsNullable extends Migration
{
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Rendre les colonnes nullable
            $table->string('facture_number', 255)->nullable()->change();
            $table->string('fournisseur', 255)->nullable()->change();
            $table->dateTime('date_demande')->nullable()->change();
            $table->dropColumn('is_read'); // Remplacé par read_at
            // Ajouter les colonnes Laravel si elles manquent
            $table->string('notifiable_type')->nullable()->after('type');
            $table->unsignedBigInteger('notifiable_id')->nullable()->after('notifiable_type');
            $table->text('data')->nullable()->after('date_demande');
            $table->timestamp('read_at')->nullable()->after('data');
            $table->index(['notifiable_type', 'notifiable_id']);
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('facture_number', 255)->nullable(false)->change();
            $table->string('fournisseur', 255)->nullable(false)->change();
            $table->dateTime('date_demande')->nullable(false)->change();
            $table->boolean('is_read')->default(false);
            $table->dropColumn(['notifiable_type', 'notifiable_id', 'data', 'read_at']);
            $table->dropIndex(['notifiable_type', 'notifiable_id']);
        });
    }
}