<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doc_type_name');
            $table->string('doc_type_html_template');
            $table->string('doc_type_html_template_filename');
            $table->string('doc_type_html_template_mime');
            $table->string('doc_type_pdf_template');
            $table->string('doc_type_pdf_template_filename');
            $table->string('doc_type_pdf_template_mime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_types');
    }
}
