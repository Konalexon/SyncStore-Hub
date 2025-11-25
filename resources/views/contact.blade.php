@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Get in Touch <i class="bi bi-chat-dots-fill text-primary"></i></h1>
                <p class="lead text-muted">Have questions? We'd love to hear from you. Visit our office or send us a
                    message.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Contact Info & Map -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="bg-primary text-white p-4">
                            <h4 class="fw-bold mb-4">Contact Information</h4>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                                    <i class="bi bi-geo-alt-fill fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Address</h6>
                                    <p class="mb-0 small opacity-75">123 Commerce St, Tech City, TC 90210</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                                    <i class="bi bi-envelope-fill fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Email</h6>
                                    <p class="mb-0 small opacity-75">support@syncstorehub.com</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                                    <i class="bi bi-telephone-fill fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Phone</h6>
                                    <p class="mb-0 small opacity-75">+1 (555) 123-4567</p>
                                </div>
                            </div>
                        </div>

                        <!-- Map -->
                        <div style="height: 300px;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.9537353153169!3d-37.81720997975171!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d6a32f7f1f81!2sFederation%20Square!5e0!3m2!1sen!2sus!4v1633072871234!5m2!1sen!2sus"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 p-lg-5">
                        <h4 class="fw-bold mb-4">Send us a Message</h4>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i
                                                class="bi bi-person"></i></span>
                                        <input type="text" class="form-control border-start-0 bg-light" placeholder="John">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i
                                                class="bi bi-person"></i></span>
                                        <input type="text" class="form-control border-start-0 bg-light" placeholder="Doe">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i
                                                class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control border-start-0 bg-light"
                                            placeholder="john@example.com">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Subject</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i
                                                class="bi bi-tag"></i></span>
                                        <select class="form-select border-start-0 bg-light">
                                            <option>General Inquiry</option>
                                            <option>Support</option>
                                            <option>Sales</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control bg-light" rows="5"
                                        placeholder="How can we help you?"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                        Send Message <i class="bi bi-send-fill ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection