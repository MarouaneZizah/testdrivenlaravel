<h1>{{$concert->title}}</h1>



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
