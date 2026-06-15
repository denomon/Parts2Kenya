<div class="row g-3">
@if(!isset($quote))
<div class="col-md-12"><label class="form-label">Part Request</label><select name="part_request_id" class="form-select" required>@foreach($partRequests as $request)<option value="{{ $request->id }}">#{{ $request->id }} - {{ $request->customer->name }} - {{ $request->part_name }}</option>@endforeach</select></div>
@endif
<div class="col-md-2"><label class="form-label">Currency</label><input name="currency" class="form-control" value="{{ old('currency',$quote->currency ?? 'GBP') }}"></div>
<div class="col-md-2"><label class="form-label">Service margin</label><input name="service_margin" type="number" step="0.01" class="form-control" value="{{ old('service_margin',$quote->service_margin ?? 0) }}"></div>
<div class="col-md-2"><label class="form-label">UK handling</label><input name="uk_handling_fee" type="number" step="0.01" class="form-control" value="{{ old('uk_handling_fee',$quote->uk_handling_fee ?? 0) }}"></div>
<div class="col-md-3"><label class="form-label">Kenya shipping estimate</label><input name="kenya_shipping_estimate" type="number" step="0.01" class="form-control" value="{{ old('kenya_shipping_estimate',$quote->kenya_shipping_estimate ?? 0) }}"></div>
<div class="col-md-3"><label class="form-label">Customs estimate</label><input name="customs_estimate" type="number" step="0.01" class="form-control" value="{{ old('customs_estimate',$quote->customs_estimate ?? 0) }}"></div>
<div class="col-md-4"><label class="form-label">Expires at</label><input name="expires_at" type="datetime-local" class="form-control" value="{{ old('expires_at', isset($quote) && $quote->expires_at ? $quote->expires_at->format('Y-m-d\\TH:i') : '') }}"></div>
<div class="col-12"><label class="form-label">Notes</label><textarea name="notes" class="form-control">{{ old('notes',$quote->notes ?? '') }}</textarea></div>
</div>
