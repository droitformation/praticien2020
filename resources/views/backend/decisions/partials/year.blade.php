<div class="card">
    <div class="card-body">
        <h3>{{ $year }}</h3>

        <div class="mt-4">
            <ul class="nav nav-tabs nav-pills" id="myTab" role="tablist">
                @foreach($dates->keys() as $i => $month)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-month {{ $i == 0 ? 'active' : '' }}" id="month_{{ $month }}" data-toggle="tab" href="#tabmonth_{{ $month }}" role="tab">
                            {{ strftime("%B",  mktime(0, 0, 0, $month, 10)) }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content w-100  pt-5 pb-3" id="myTabContent">
                @foreach($dates as $month => $days)
                    <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="tabmonth_{{ $month }}" role="tabpanel" aria-labelledby="home-tab">
                        <div class="d-flex flex-row">
                            @foreach($days->chunk(4) as $row)
                                <div class="list-dates">
                                    @foreach($row as $day)
                                        <div class="card card-categorie bg-light border w-100 mb-3">
                                            <div class="card-body">
                                                <div class="d-flex flex-row justify-content-between w-100">
                                                    <div><p><a href="{{ url('backend/decisions/'.$day['date'].'/'.$year) }}">{{ $day['date'] }}</a></p></div>
                                                    <div><p><strong>{{ $day['count'] }}</strong></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
