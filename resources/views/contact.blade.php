@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center mb-5">
                <h1 class="fw-bold">Get in Touch</h1>
                <p class="lead text-secondary">Have questions? We'd love to hear from you.</p>
            </div>
        </div>

        <div class="row g-5">
            <div class="col-lg-5">
                <div class="card bg-primary text-white border-0 shadow-lg h-100">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4">Contact Information</h3>
                        <p class="mb-5 opacity-75">Fill out the form and our team will get back to you within 24 hours.</p>

                        <div class="d-flex gap-3 mb-4">
                            <i class="bi bi-geo-alt fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Address</h6>
                                <p class="mb-0 opacity-75">123 Commerce St, Tech City, TC 90210</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-4">
                            <i class="bi bi-envelope fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Email</h6>
                                <p class="mb-0 opacity-75">support@syncstorehub.com</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-4">
                            <i class="bi bi-telephone fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Phone</h6>
                                <p class="mb-0 opacity-75">+1 (555) 123-4567</p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-4"></i></a>
                            <a href="#" class="text-white me-3"><i class="bi bi-twitter-x fs-4"></i></a>
                            <a href="#" class="text-white me-3"><i class="bi bi-instagram fs-4"></i></a>
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Send Message</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection