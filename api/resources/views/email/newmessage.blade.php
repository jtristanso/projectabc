@component('email.header')
@endcomponent
<span class="text">
    <h3>New Message</h3>
    Hello {{$user->username}}!
    <br>
    <br>
    Your account has new message. Kindly <a href="http://idfactory.ph">login</a> and find out on you messages.
    <br>
    <br>
</span>
@component('email.footer')
@endcomponent