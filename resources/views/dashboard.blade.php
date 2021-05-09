@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-12">
          
          @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                <p>{{ $message }}</p>
            </div>
            <?php Session::forget('success');?>
          @endif
          
          @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
               <p>{{ $message }}</p>
            </div>
            <?php Session::forget('error');?>
         @endif
         
        <div class="card text-white bg-primary mb-3">
            <div class="card-body" style="text-align:center; font-size:18px;">
                Currently you have available <strong>{{ $userSubscription }}</strong> diagnostic checks! 
            </div>
        </div>
        
         @if ( $userSubscription !=0 )
         <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col">
                          <form name="goBack" id="goBack" action="{{ url('/home') }}" method="get"> {{ csrf_field() }}
                  <button type="submit" class="btn btn-primary btn-sm"><strong><<</strong> Go to subscriptions</button>
                        </form> 
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"> 
                          <form name="goBack" id="goBack" action="{{ url('/dashboard/digital-assitant/symptom-checker') }}" method="get"> {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary btn-sm"><strong>>></strong> Go to diagnostic check</button>
                        </form> 
                    </tr>
                    </thead>
                </table>
                @else
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <p>You can't access the diagnostic check section. Buy a subscription from the 'Subscription' section first. </p>
                         <form name="goBack" id="goBack" action="{{ url('/home') }}" method="get"> {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary btn-sm"><strong><<</strong> Go to subscriptions</button>
                        </form> 
                    </div>
                </div>
                @endif

           
            @if(!empty($selectedSymptomNames))
                Date: <?php echo date("Y/m/d")  ?>
                <br>
                Your selected symptoms: &nbsp;
                @foreach ($selectedSymptomNames as $selectedSymptomName)
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="right" title="Tooltip on right"> {{ $selectedSymptomName }} </button>
                @endforeach
                
            @endif
            <p></p>
            
            @if (!empty($diagnosis))
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">
                    Diagnostic/s:
                </a>
               <?php
                     array_map(function ($issue) {
                        echo "\n", "\t", "<b>",$issue['Issue']['Name']," (", $issue['Issue']['Accuracy'],"%)</b>\n";
                        echo "Specialisations -> ";
                        array_map(function ($spec)
                        {
                        echo $spec['Name'],"(",$spec['ID'],") &nbsp;", "\t";
                        }, $issue['Specialisation']);
                        echo "<br>";
                        echo "<br>";
                    }, $diagnosis);
               ?>
            @else
            <div class="alert alert-warning" role="alert">
                We don't find any diagnostics that matches with your selection.
            </div>
            @endif
            
            @if(!empty($specialisations))
                <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active"> Specialisation/s: </a>
                <?php
                    array_map(function ($specialisation) {
                    echo "\n", "\t", $specialisation['Name']," (", $specialisation['Accuracy'],"%)";
                     echo "<br>";
                }, $specialisations);
                ?>
            @endif
            
            <br>
         @if(!empty($issuesInfoArray))
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active"> Diagnostics details: </a>
             <?php $last= count($issuesInfoArray); ?>
            @for ($i = 0; $i < $last; $i++)
                <p></p>
                <h3>{{$issuesInfoArray[$i]['Name']}}</h3>
                <p><span style="color:red;">Short description: </span> {{$issuesInfoArray[$i]['DescriptionShort']}}</p>
                <p><span style="color:red;">Description: </span>       {{$issuesInfoArray[$i]['Description']}}</p>
                <p><span style="color:red;">Medical condition: </span> {{$issuesInfoArray[$i]['MedicalCondition']}}</p>
                <p><span style="color:red;">Possibile symptoms: </span>{{$issuesInfoArray[$i]['PossibleSymptoms']}}</p>
                <p><span style="color:red;">Diagnostic name: </span>{{$issuesInfoArray[$i]['ProfName']}}</p>
                <p><span style="color:red;">Symptoms:</span> {{$issuesInfoArray[$i]['Synonyms']}}</p>
                <p><span style="color:red;">Treatment description:</span>{{$issuesInfoArray[$i]['TreatmentDescription']}}</p>
                <p></p>
            @endfor
         @endif
         
         <br>
         @if(!empty($proposedSymptoms))
         <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">Associated symptoms: </a>
         <?php
            print "<pre>";
            array_map(function ($var) {
                echo "\n", $var['Name'];
            }, $proposedSymptoms);
        ?>
        @endif
        
          @if(!empty($redFlagTexts))
        <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">Red flags: </a>
                
            @foreach ($redFlagTexts as $text)
            <div class="alert alert-danger" role="alert">
            {{ $text }}
            </div>
            @endforeach
        </div>
        @endif
    </div>
 </div>
@endsection

