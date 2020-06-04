@extends('layouts.frontend')

@section('header')
<div id="post-header" class="page-header">
    <div class="background-img"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="text-dark">Contact Us</h1>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-md-6">
    <div class="section-row">
        <h3>Contact Information</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <ul class="list-style">
            <li><p><strong>Email:</strong> <a href="#">kmrank111@email.com</a></p></li>
            <li><p><strong>Phone:</strong> +91 96871 10300</p></li>
            <li><p><strong>Address:</strong> Shree Recidency, Rajkot</p></li>
        </ul>
    </div>
</div>
<div class="col-md-5 col-md-offset-1">
    <div class="section-row">
        <h3>Send A Message</h3>
        <div id="message">
            <p id="message" class=""></p>
        </div>
        <form method="POST" id="contact-us">
            @csrf
            <div class="row">
                <div class="col-md-7">
                    <div class="form-group">
                        <span>Email</span>
                        <input class="input" id="email" type="email" name="email" required>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <span>Subject</span>
                        <input class="input" id="subject" type="text" name="subject" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <span>Message</span>
                        <textarea class="input" id="message" name="message" required></textarea>
                    </div>
                    <button type="submit" id="contact-us-submit" class="primary-button">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#contact-us').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{route('contactus.store')}}",
                method: 'POST',
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.error) {
                        $('#message').addClass("text-danger")
                        $('#message').text(data.error);
                        return false;
                    }
                    $('#message').addClass("text-success")
                    $('#message').text(data.success);
                    $("#contact-us")[0].reset();
                }
            });
        });
    });
</script>
@endsection