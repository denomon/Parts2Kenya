<p>Hello {{ $quote->partRequest->customer->name }},</p>
<p>Your Parts2Kenya quote for <strong>{{ $quote->partRequest->part_name }}</strong> is ready.</p>
<p><a href="{{ route('quotes.public.show', $quote) }}">View and accept your quote</a></p>
<p>Parts2Kenya Export Ltd</p>
