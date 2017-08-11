@if(Session::has('success'))
    <session-messages :type="'success'" :message="'{{Session::get('success')}}'"></session-messages>
@endif
@if(Session::has('error'))
    <session-messages :type="'error'" :message="'{{Session::get('error')}}'"></session-messages>
@endif
