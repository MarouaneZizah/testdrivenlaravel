<h1>{{$concert->title}}</h1>
<h2>{{$concert->subtitle}}</h2>
<p>{{$concert->formatted_date}}</p>
<p>{{$concert->formatted_start_Time}}</p> --}}
<p>{{number_format($concert->price/100, 2)}}</p>
<p>{{$concert->adresse}}</p>
<p>{{$concert->city}}</p>
<p>{{$concert->zip}}</p>
<p>{{$concert->additional_info}}</p>
