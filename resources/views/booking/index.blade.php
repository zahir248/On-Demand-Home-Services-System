@extends('layouts.user_type.auth')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div>
    <div class="row flex-lg-row">
        <div class="col-lg-8 col-12 order-1">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Bookings</h5>
                        </div>
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button" data-bs-toggle="modal" data-bs-target="#createBookingModal">+&nbsp; New Booking</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Customer
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Service
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Payment Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($bookings->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center text-xs font-weight-bold mb-0">
                                            No bookings available
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($bookings as $booking)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $booking->id }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $booking->customer->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $booking->service->service_name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $booking->scheduled_at }}</p>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge 
                                                @if($booking->payment_status === 'paid') bg-success
                                                @elseif($booking->payment_status === 'pending') bg-warning
                                                @elseif($booking->payment_status === 'failed') bg-danger
                                                @else bg-secondary
                                                @endif"
                                                data-id="{{ $booking->id }}" 
                                                data-status="{{ $booking->payment_status }}"
                                                style="cursor: pointer;" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#bookingPaymentStatusModal">
                                                {{ ucfirst($booking->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge @if($booking->status === 'completed') bg-success
                                                @elseif($booking->status === 'confirmed') bg-warning
                                                @elseif($booking->status === 'pending') bg-warning
                                                @elseif($booking->status === 'canceled') bg-danger
                                                @else bg-secondary
                                                @endif"
                                                data-id="{{ $booking->id }}"
                                                data-status="{{ $booking->status }}"
                                                style="cursor: pointer;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#bookingStatusModal">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="mx-2 text-secondary edit-booking" data-id="{{ $booking->id }}" data-bs-toggle="modal" data-bs-target="#editBookingModal">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="mx-2 text-secondary delete-booking" data-id="{{ $booking->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="mt-3 mx-3">
                            {{ $bookings->links() }} <!-- Laravel pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12 order-2">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Calendar</h5>
                </div>
                <div class="card-body">
                    <div id="booking-calendar-toolbar" class="mb-2"></div>
                    <div id="booking-calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('booking.create')
@include('booking.payment_status')
@include('booking.status')

@endsection

@push('styles')

<style>
    #booking-calendar-toolbar {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    .calendar-nav-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 0.7rem;
        width: 100%;
    }
    .calendar-nav-btns {
        display: flex;
        gap: 0.2rem;
        background: #c04a6b;
        border-radius: 20px;
        padding: 0.15rem 0.3rem;
        justify-content: center;
        align-items: center;
    }
    .calendar-btn {
        background: transparent;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 2.1rem;
        height: 2.1rem;
        font-size: 1.2rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }
    .calendar-btn:active, .calendar-btn:focus {
        background: rgba(255,255,255,0.12);
    }
    .calendar-btn.today {
        background: #e3a7bb;
        color: #fff;
        border-radius: 16px;
        width: auto;
        height: 2.1rem;
        padding: 0 1.2rem;
        font-size: 1rem;
        font-weight: 500;
        margin-left: 0.7rem;
    }
    .calendar-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #34405a;
        letter-spacing: 1px;
        margin-bottom: 1.1rem;
        margin-top: 0.2rem;
        text-align: center;
        text-transform: uppercase;
        width: 100%;
        display: flex;
        justify-content: center;
    }
    .calendar-view-switcher {
        display: flex;
        background: #e5e5e5;
        border-radius: 25px;
        overflow: hidden;
        width: fit-content;
        margin: 0 auto 1.1rem auto;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        justify-content: center;
        align-items: center;
    }
    .calendar-view-btn {
        border: none;
        background: transparent;
        font-weight: 500;
        font-size: 1rem;
        padding: 0.5rem 1.5rem;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
        border-radius: 25px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .calendar-view-btn.active {
        background: #555;
        color: #fff;
    }
    .calendar-view-btn:not(.active) {
        background: #c04a6b;
        color: #fff;
        opacity: 1;
    }
    /* FullCalendar grid tweaks */
    #booking-calendar .fc {
        background: #fff;
        border-radius: 12px;
        padding: 0.5rem 0.5rem 0.7rem 0.5rem;
        box-shadow: none;
    }
    .fc .fc-scrollgrid, .fc .fc-scrollgrid-section {
        border-radius: 12px;
        border: 1px solid #ececec;
        background: #fff;
    }
    .fc .fc-daygrid-day {
        background: #fff;
    }
    .fc .fc-day-today {
        background: #fff6f9 !important;
        border-radius: 6px;
    }
    .fc .fc-daygrid-day-number {
        color: #34405a;
        font-weight: 500;
        font-size: 1rem;
        padding: 2px 0 0 4px;
    }
    .fc .fc-col-header-cell {
        background: #fff;
        color: #888;
        font-weight: 600;
        font-size: 0.95rem;
        border-bottom: 1px solid #ececec;
        padding: 0.3rem 0;
    }
    .fc .fc-daygrid-day-events {
        margin-top: 2px;
    }
    .fc-event {
        background: #c04a6b !important;
        color: #fff !important;
        border: none !important;
        border-radius: 4px !important;
        font-size: 0.85rem !important;
        padding: 2px 6px !important;
        margin-bottom: 2px !important;
    }
    .fc .fc-daygrid-more-link {
        color: #c04a6b;
        font-size: 0.85rem;
    }
    /* Responsive */
    @media (max-width: 768px) {
        .calendar-title { font-size: 1rem; }
        .calendar-btn, .calendar-view-btn { font-size: 0.9rem; }
        .calendar-nav-btns { padding: 0.1rem 0.2rem; }
        .calendar-view-btn { padding: 0.4rem 0.7rem; }
    }
</style>
@endpush

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('booking-calendar');
        var toolbarEl = document.getElementById('booking-calendar-toolbar');
        if (!calendarEl || !toolbarEl) return;

        // Prepare events
        var bookingEvents = [
            @foreach($bookings as $booking)
                @if($booking->scheduled_at && !empty($booking->scheduled_at))
                {
                    title: '{{ $booking->service->service_name ?? 'No Service' }} - {{ $booking->customer->name ?? 'No Customer' }}',
                    start: '{{ \Carbon\Carbon::parse($booking->scheduled_at)->format('Y-m-d\TH:i:s') }}',
                    color: '{{ $booking->status == "confirmed" ? "#198754" : "#ffc107" }}',
                    extendedProps: {
                        status: '{{ $booking->status }}',
                        bookingId: {{ $booking->id }}
                    }
                }{{ !$loop->last ? ',' : '' }}
                @endif
            @endforeach
        ];

        // State
        let currentView = 'dayGridMonth';
        let calendar;
        let currentDate = new Date();

        // Toolbar HTML
        function renderToolbar(date, view) {
            // Format month/year
            const monthNames = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
            const title = monthNames[date.getMonth()] + ' ' + date.getFullYear();
            toolbarEl.innerHTML = `
                <div class="calendar-nav-group">
                    <span class="calendar-nav-btns">
                        <button class="calendar-btn prev" title="Previous"><span>&lt;</span></button>
                        <button class="calendar-btn next" title="Next"><span>&gt;</span></button>
                    </span>
                    <button class="calendar-btn today" title="Today">Today</button>
                </div>
                <div class="calendar-title">${title}</div>
                <div class="calendar-view-switcher">
                    <button class="calendar-view-btn month${view==='dayGridMonth'?' active':''}">Month</button>
                    <button class="calendar-view-btn week${view==='timeGridWeek'?' active':''}">Week</button>
                    <button class="calendar-view-btn day${view==='timeGridDay'?' active':''}">Day</button>
                </div>
            `;
            // Attach events
            toolbarEl.querySelector('.prev').onclick = function() { calendar.prev(); updateToolbar(); };
            toolbarEl.querySelector('.next').onclick = function() { calendar.next(); updateToolbar(); };
            toolbarEl.querySelector('.today').onclick = function() { calendar.today(); updateToolbar(); };
            toolbarEl.querySelector('.month').onclick = function() { calendar.changeView('dayGridMonth'); updateToolbar(); };
            toolbarEl.querySelector('.week').onclick = function() { calendar.changeView('timeGridWeek'); updateToolbar(); };
            toolbarEl.querySelector('.day').onclick = function() { calendar.changeView('timeGridDay'); updateToolbar(); };
        }
        function updateToolbar() {
            const view = calendar.view.type;
            const date = calendar.getDate();
            renderToolbar(date, view);
        }
        // Calendar
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: currentView,
            height: 'auto',
            headerToolbar: false, // Hide default toolbar
            events: bookingEvents,
            eventDisplay: 'block',
            timeZone: 'local',
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                meridiem: 'short'
            },
            eventDidMount: function(info) {
                if (info.event.title) {
                    info.el.setAttribute('title', info.event.title);
                }
            },
            eventClick: function(info) {
                if (info.event.extendedProps && info.event.extendedProps.bookingId) {
                    var editBtn = document.querySelector('.edit-booking[data-id="' + info.event.extendedProps.bookingId + '"]');
                    if (editBtn) {
                        editBtn.click();
                    }
                }
            },
            datesSet: function() { updateToolbar(); }
        });
        calendar.render();
        updateToolbar();
    });
</script>
