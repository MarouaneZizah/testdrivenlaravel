<h1>{{$concert->title}}</h1>
<h2>{{$concert->subtitle}}</h2>
<p>{{$concert->date->format('F j, Y')}}</p>
<p>{{$concert->date->format('g:ia')}}</p>
<p>{{$concert->date->price}}</p>


 $table->id();
            $table->string('title');
            $table->string('subtitle');
            $table->datetime('date');
            $table->integer('price');
            $table->string('adresse');
            $table->string('city');
            $table->string('zip');
            $table->longText('additional_info');
            $table->timestamps();
            $table->timestamps();