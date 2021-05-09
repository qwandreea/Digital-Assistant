@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-12">
          <form method="POST" id="diagnosis-form"  action="/dashboard/digital-assistant/diagnosis"> {{ csrf_field() }}
          
          @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Enter your birthday year</span>
                </div>
                <input type="text" id="iyear" name="year" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>
            
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Select your gender</span> &nbsp; &nbsp;
                </div>
                <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="Female" checked>
                <label class="form-check-label" for="gender">Female</label>
                </div>
            
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="Male">
                <label class="form-check-label" for="gender">Male</label>
            </div>
            </div>
            
             <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Select your symptoms</span>
                </div>
                <select class="form-control" id="iID">
                        @for($i=0; $i<count($symptoms);$i++)
                            <option value="{{ $symptoms[$i]['ID'] }}">{{ $symptoms[$i]['Name'] }}</option>
                        @endfor
                </select>
            </div>
            
            <hr>
            <p>Selected symptoms</p>
            <ul class="list-group" id="selectedSymptoms">
            </ul>
            
            <br>
            <button type="submit" class="btn btn-success" id="check-button">Check</button>
            
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="application/javascript">
    
        var year = $("#iyear").val();
         var i=0;
        
        $("#iID").change(function(){
           
            var txt = $("#iID option:selected").text();
            var val = $("#iID option:selected").val();
            var li = document.createElement("li");
            li.className = "list-group-item list-group-item-primary";
            var t = document.createTextNode(txt);
            li.appendChild(t);
		    document.getElementById("selectedSymptoms").appendChild(li);
		    
		    var form =  $("form#diagnosis-form");
		    $('<input />').attr('type', 'hidden')
            .attr('name', "symptomIDs["+i+"]")
            .attr('value', val)
            .appendTo(form);
            
             $('<input />').attr('type', 'hidden')
            .attr('name', "symptomNames["+i+"]")
            .attr('value', txt)
            .appendTo(form);
            
            i++;
        });
    </script>
@endpush