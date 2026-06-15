@extends('layouts.app')

@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="hero-card">
                <div class="row align-items-center g-5">
                    <div class="col-lg-7">
                        <span class="hero-badge">UK sourced • Kenya delivered</span>

                        <h1 class="hero-title">
                            Genuine UK used car parts, sourced and shipped to Kenya.
                        </h1>

                        <p class="hero-text">
                            Tell us the part you need. We source it from trusted UK suppliers,
                            send you a clear quote, and include paid orders in our monthly
                            consolidated Kenya shipments.
                        </p>

                        <div class="d-flex gap-3 flex-wrap mt-4">
                            <a href="{{ route('part-requests.create') }}" class="btn btn-warning btn-lg px-4">
                                Request a Part
                            </a>

                            <a href="{{ route('tracking.form') }}" class="btn btn-outline-light btn-lg px-4">
                                Track Order
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="hero-panel">
                            <h5 class="mb-3">How it works</h5>

                            <div class="mini-step">
                                <span>1</span>
                                <div>
                                    <strong>Submit request</strong>
                                    <p>Vehicle details, part name, photos and delivery location.</p>
                                </div>
                            </div>

                            <div class="mini-step">
                                <span>2</span>
                                <div>
                                    <strong>We source it</strong>
                                    <p>Our team checks UK suppliers and prepares a quote.</p>
                                </div>
                            </div>

                            <div class="mini-step">
                                <span>3</span>
                                <div>
                                    <strong>Approve and pay</strong>
                                    <p>Pay securely only after accepting the quote.</p>
                                </div>
                            </div>

                            <div class="mini-step">
                                <span>4</span>
                                <div>
                                    <strong>Ship to Kenya</strong>
                                    <p>Paid orders are batched into monthly shipments.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="trust-row">
                <div class="trust-item">
                    <h3>No inventory risk</h3>
                    <p>We source only after your request, so quotes are based on real availability.</p>
                </div>

                <div class="trust-item">
                    <h3>Quote before payment</h3>
                    <p>You review the cost before paying. No surprise checkout basket.</p>
                </div>

                <div class="trust-item">
                    <h3>Kenya focused</h3>
                    <p>Built around consolidated UK-to-Kenya shipment batches.</p>
                </div>
            </div>

            <div class="popular-section">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <div>
                        <h2>Commonly requested parts</h2>
                        <p class="text-muted mb-0">Request anything — these are examples of parts we can help source.</p>
                    </div>

                    <a href="{{ route('part-requests.create') }}" class="btn btn-dark">
                        Start Request
                    </a>
                </div>

                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="part-card">Side mirrors</div>
                    </div>
                    <div class="col-md-3">
                        <div class="part-card">Headlights</div>
                    </div>
                    <div class="col-md-3">
                        <div class="part-card">Bumpers</div>
                    </div>
                    <div class="col-md-3">
                        <div class="part-card">Engines & gearboxes</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
