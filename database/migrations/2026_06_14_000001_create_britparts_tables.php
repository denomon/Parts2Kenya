<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('email')->unique(); $table->string('phone')->nullable(); $table->string('whatsapp')->nullable(); $table->string('kenya_delivery_location')->nullable(); $table->timestamps();
        });
        Schema::create('part_requests', function (Blueprint $table) {
            $table->id(); $table->foreignId('customer_id')->constrained()->cascadeOnDelete(); $table->string('vehicle_make'); $table->string('vehicle_model'); $table->unsignedSmallInteger('vehicle_year')->nullable(); $table->string('registration_number')->nullable(); $table->string('vin')->nullable(); $table->string('part_name'); $table->text('part_description')->nullable(); $table->string('urgency')->nullable(); $table->string('photo_path')->nullable(); $table->string('status')->default('Pending Sourcing'); $table->text('admin_notes')->nullable(); $table->timestamps();
        });
        Schema::create('quotes', function (Blueprint $table) {
            $table->id(); $table->foreignId('part_request_id')->constrained()->cascadeOnDelete(); $table->uuid('public_token')->unique(); $table->string('status')->default('Draft'); $table->char('currency', 3)->default('GBP'); $table->decimal('supplier_cost', 12, 2)->default(0); $table->decimal('service_margin', 12, 2)->default(0); $table->decimal('uk_handling_fee', 12, 2)->default(0); $table->decimal('kenya_shipping_estimate', 12, 2)->default(0); $table->decimal('customs_estimate', 12, 2)->default(0); $table->timestamp('expires_at')->nullable(); $table->text('notes')->nullable(); $table->timestamp('sent_at')->nullable(); $table->timestamp('accepted_at')->nullable(); $table->timestamps();
        });
        Schema::create('quote_items', function (Blueprint $table) {
            $table->id(); $table->foreignId('quote_id')->constrained()->cascadeOnDelete(); $table->string('description'); $table->string('supplier_name')->nullable(); $table->unsignedInteger('quantity')->default(1); $table->decimal('unit_price', 12, 2); $table->decimal('total_price', 12, 2); $table->timestamps();
        });
        Schema::create('shipment_batches', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->date('month'); $table->string('status')->default('Open'); $table->date('departure_date')->nullable(); $table->date('arrival_estimate')->nullable(); $table->text('notes')->nullable(); $table->timestamps();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); $table->foreignId('customer_id')->constrained()->cascadeOnDelete(); $table->foreignId('quote_id')->constrained()->cascadeOnDelete(); $table->foreignId('shipment_batch_id')->nullable()->constrained()->nullOnDelete(); $table->string('order_number')->unique(); $table->string('status')->default('Awaiting Payment'); $table->decimal('total_amount', 12, 2); $table->char('currency', 3)->default('GBP'); $table->timestamps();
        });
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); $table->foreignId('order_id')->constrained()->cascadeOnDelete(); $table->string('stripe_session_id')->nullable()->index(); $table->string('stripe_payment_intent')->nullable(); $table->decimal('amount', 12, 2); $table->char('currency', 3)->default('GBP'); $table->string('status')->default('pending'); $table->timestamp('paid_at')->nullable(); $table->timestamps();
        });
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); $table->foreignId('order_id')->constrained()->cascadeOnDelete(); $table->string('invoice_number')->unique(); $table->decimal('amount', 12, 2); $table->char('currency', 3)->default('GBP'); $table->timestamp('issued_at')->nullable(); $table->string('pdf_path')->nullable(); $table->timestamps();
        });
        Schema::create('shipment_tracking_events', function (Blueprint $table) {
            $table->id(); $table->foreignId('order_id')->constrained()->cascadeOnDelete(); $table->string('status'); $table->string('location')->nullable(); $table->text('description')->nullable(); $table->timestamp('occurred_at'); $table->timestamps();
        });
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('contact_name')->nullable(); $table->string('email')->nullable(); $table->string('phone')->nullable(); $table->string('website')->nullable(); $table->text('notes')->nullable(); $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('suppliers'); Schema::dropIfExists('shipment_tracking_events'); Schema::dropIfExists('invoices'); Schema::dropIfExists('payments'); Schema::dropIfExists('orders'); Schema::dropIfExists('shipment_batches'); Schema::dropIfExists('quote_items'); Schema::dropIfExists('quotes'); Schema::dropIfExists('part_requests'); Schema::dropIfExists('customers');
    }
};
