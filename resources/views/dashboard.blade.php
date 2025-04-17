@extends('layouts.user_type.auth')

@section('content')

  <div class="row">
    @if(auth()->user()->role == 'admin')
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Providers</p>
                <h5 class="font-weight-bolder mb-0">
                  $53,000
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Customer</p>
                <h5 class="font-weight-bolder mb-0">
                  2,300
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Pending Approvals</p>
                <h5 class="font-weight-bolder mb-0">
                  +3,462
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Revenue</p>
                <h5 class="font-weight-bolder mb-0">
                  $103,430
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Add Map Section -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <h6>
            @if(auth()->user()->role == 'admin')
              All Service Providers Map
            @elseif(auth()->user()->role == 'provider')
              Your Business Location
            @else
              Service Locations
            @endif
          </h6>
        </div>
        <div class="card-body p-3">
          <div id="map" style="height: 400px;"></div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('dashboard')
  <!-- Add Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
  
  <!-- Add Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

  <script>
    window.onload = function() {
      var ctx = document.getElementById("chart-bars").getContext("2d");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Sales",
            tension: 0.4,
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            backgroundColor: "#fff",
            data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
            maxBarThickness: 6
          }, ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
              },
              ticks: {
                suggestedMin: 0,
                suggestedMax: 500,
                beginAtZero: true,
                padding: 15,
                font: {
                  size: 14,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
                color: "#fff"
              },
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false
              },
              ticks: {
                display: false
              },
            },
          },
        },
      });

      var ctx2 = document.getElementById("chart-line").getContext("2d");

      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
              label: "Mobile apps",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#cb0c9f",
              borderWidth: 3,
              backgroundColor: gradientStroke1,
              fill: true,
              data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
              maxBarThickness: 6

            },
            {
              label: "Websites",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#3A416F",
              borderWidth: 3,
              backgroundColor: gradientStroke2,
              fill: true,
              data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
              maxBarThickness: 6
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#b2b9bf',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 20,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });
    }

    // Get user data and role from PHP
    var users = @json($users);
    var currentUser = @json($currentUser);
    var userRole = currentUser.role;

    // Initialize the map centered on Malaysia
    var map = L.map('map').setView([3.8, 102.3], 4);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        minZoom: 5,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Set bounds for Malaysia
    var southWest = L.latLng(0, 97);
    var northEast = L.latLng(8, 106);
    var bounds = L.latLngBounds(southWest, northEast);
    map.setMaxBounds(bounds);

    // Display markers based on user role
    if (userRole === 'admin') {
        // Admin sees all user locations
        document.querySelector('.card-header h6').textContent = 'All Service Providers Map';
        
        users.forEach(function(user) {
            if (user.latitude && user.longitude) {
                var marker = L.marker([user.latitude, user.longitude]).addTo(map);
                marker.bindPopup(
                    "<b>" + user.business_name + "</b><br>" +
                    (user.role === 'provider' ? "Owner: " + user.name + "<br>" : "") +
                    "Address: " + user.address
                );
            }
        });
        
        // Fit map to show all markers
        if (users.some(user => user.latitude && user.longitude)) {
            var markerBounds = [];
            users.forEach(function(user) {
                if (user.latitude && user.longitude) {
                    markerBounds.push([user.latitude, user.longitude]);
                }
            });
            map.fitBounds(markerBounds);
            if (map.getZoom() > 10) {
                map.setZoom(10);
            }
        }
    } else if (userRole === 'provider') {
        // Provider only sees their own location
        document.querySelector('.card-header h6').textContent = 'Your Business Location';
        
        if (currentUser.latitude && currentUser.longitude) {
            var marker = L.marker([currentUser.latitude, currentUser.longitude]).addTo(map);
            marker.bindPopup(
                "<b>" + currentUser.business_name + "</b><br>" +
                "Owner: " + currentUser.name + "<br>" +
                "Address: " + currentUser.address
            ).openPopup();
            
            // Center map on provider's location with closer zoom
            map.setView([currentUser.latitude, currentUser.longitude], 13);
        } else {
            // If provider doesn't have location data
            document.querySelector('.card-body').innerHTML = '<div class="alert alert-warning">Your business location is not set. Please update your profile with your full address.</div>';
        }
    } else {
        // For other roles or customers if needed
        document.querySelector('.card-header h6').textContent = 'Service Locations';
        // You could add default behavior here
    }
  </script>

@endpush
