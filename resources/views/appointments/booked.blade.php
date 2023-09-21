@if($getUserAppointments)
    @foreach($getUserAppointments as $userAppointments)
    <div class="appt-card">
        <div class="appt-card-body">
            
            <!-- setting id of appointment -->
            <input type="hidden" class="appt_id" name="appt_id" value="{{$userAppointments->id}}">
            <input type="hidden" class="previous_date" name="previous_date" value="{{ date('Y-m-d', strtotime($userAppointments->appt_date)) }}">
            <input type="hidden" class="previous_time" name="previous_time" value="{{ date('H:i', strtotime($userAppointments->appt_time)) }}">


            <!-- <h4 class="appt-u-title"><b>Name: </b> {{ $userAppointments->name }}</h4>
            <p class="appt-u-email"><b>Email: </b>{{ $userAppointments->email }}</p>
            <p class="appt-u-mobile"><b>Phone: </b>{{ $userAppointments->mobile }}</p> -->
            <p class="appt-u-datetime"><b class="c-inner-text">When: </b>{{ date('M j Y', strtotime($userAppointments->appt_date)) }}, {{ date('H:i', strtotime($userAppointments->appt_time)) }} ({{ $userAppointments->timezone }})</p>
            <p class="appt-u-description"><b class="c-inner-text">Purpose: </b>{{ $userAppointments->description }}</p>
            <div class="appt-buttons">
            <button type="button" class="cancel-btn">Cancel</button>
            <button type="button" class="reschedule-btn">Reschedule</button>
            </div>
        </div>
    </div>
    @endforeach
@endif