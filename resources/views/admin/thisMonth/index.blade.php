@extends('layouts.backend.app')

@section('content')
<style>
	strong{
		font-weight: bold;
	}
	table.dataTable thead .sorting:after{
		display: none;
	}
	table.dataTable thead .sorting_asc:after{
		display: none;
	}
	.badge{
		border-radius: 28px;
		text-transform: capitalize;
		padding: 2px 10px !important;
	}
	#DataTables_Table_0_paginate{
		float: right;
	}
	.pagination #DataTables_Table_0_previous{
		border: 1px solid #1175b3;
	    border-radius: 5px;
	    padding: 0px 10px;
	    background: #1175b3; 
	}
	.pagination #DataTables_Table_0_previous a{
	    color: #fff !important;
	}
	.pagination #DataTables_Table_0_next{
		border: 1px solid #1175b3;
	    border-radius: 5px;
	    padding: 0px 10px;
	    background: #1175b3; 
	}
	.pagination #DataTables_Table_0_next a{
	    color: #fff !important;
	}
	.pagination .active{
		border: 1px solid #1175b3;
	    border-radius: 5px;
	    padding: 0px 10px;
	    background: #1175b3;
	    margin: 0px 6px;
	}
	.pagination .active a{
		color: #fff !important;
	}
	#DataTables_Table_0_length .text-muted .input-sm{
		margin: 0px 6px;
	}
	#DataTables_Table_0_filter .text-muted .form-control-sm{
		margin: 0px 0px 0px 10px;
	}
	#DataTables_Table_0{
		margin-bottom: 6%;
		margin-top: 2%;
	}
	.dropdown-item.active, .dropdown-item:active{
		outline: none;
	}
	:focus {
	    outline: none !important;
	}
</style>
<div class="container-xl">
	<div class="page-header">
	    <div class="row">
	    	<div class="col-md-6 col-12 col-xs-12 col-sm-12" align="left">
		    	<h2 class="page-title">IPDs  <span class="text-muted text-h5 mt-2 pl-2">{{$ipds->total()}} items</span></h2>
	    	</div>
	    </div>
	</div>
	@if($ipds->count())
	<div class="row">
	    <div class="col-md-12 col-12" style="overflow-x:auto;">
	      <table class="table table-bordered table-hover">
	        <thead>
	          <tr>
	            <th>Patient</th>
	            <th>Phone</th>
	            <th>user</th>
	            <th>Doctor</th>
	            <th>Hospital</th>
	            <th>Room</th>
	            <th>treatment</th>
	            <th>surgery_date</th>
	            <th>arrival time</th>
	            <th>treatment time</th>
	            <th>test</th>
	            <th>aadhar</th>
	            <th>insurance</th>
	            <th>payment type</th>
	            <th>billed amt</th>
	            <th>settled amt</th>
	            <th>hospital share</th>
	            <th>glamyo share</th>
	            <th>status</th>
	            <th>Action</th>
	          </tr>
	        </thead>
	        <tbody style="padding-bottom: 200px;">
	        	@foreach($ipds as $ipd)
	        	<tr>
	        		<td>{{$ipd->patient}}</td>
	        		<td>{{$ipd->phone}}</td>
	        		<td>{{$ipd->user->name}}</td>
	        		<td>{{$ipd->doctor->name}}</td>
	        		<td>{{$ipd->hospital->name}}</td>
	        		<td>{{$ipd->room->name}}</td>
	        		<td>{{$ipd->treatment->name}}</td>
	        		<td><?php $date = date('d-M-Y', strtotime($ipd->surgery_date)); echo $date; ?></td>
	        		<td>
	        			<?php $arrival_time = $ipd->arrival_time; echo date('h:i a', strtotime($arrival_time)); ?>
	        		</td>
	        		<td>
	        			<?php $treatment_time = $ipd->treatment_time; echo date('h:i a', strtotime($treatment_time)); ?>
	        		</td>
	        		<td>{{$ipd->test}}</td>
	        		<td>
	        			<img src="{{asset('aadhar/'.$ipd->aadhar)}}" width="50px">
	        		</td>
	        		@if($ipd->insurance == NULL)
	        		<td class="text-muted">NULL</td>
	        		@else
	        		<td>
	        			<img src="{{asset('insurance/'.$ipd->insurance)}}" width="50px">
	        		</td>
	        		@endif
	        		<td>{{$ipd->payment->name}}</td>
	        		<td>{{$ipd->billed_amt}}</td>
	        		<td>{{$ipd->settled_amt}}</td>
	        		<td>{{$ipd->hospital_share}}</td>
	        		<td>{{$ipd->glamyo_share}}</td>
	        		@if($ipd->status == NULL)
	        		<td class="badge bg-info" style="margin: 10px auto;display: block;">Active</td>
	        		@elseif($ipd->status == 1)
	        		<td class="badge bg-success" style="margin: 10px auto;display: block;">Completed</td>
	        		@elseif($ipd->status == 2)
	        		<td class="badge bg-danger" style="margin: 10px auto;display: block;">Cancelled</td>
	        		@endif
	        		<td class="text-center">
	                    <div class="dropdown">
						  <a type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    <i class="icon" data-feather="more-vertical"></i>
						  </a>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						  	@if($ipd->status == NULL)
				            <form method="post" action="{{ route('admin.ipd.complete', $ipd->id) }}">
				                @csrf
				                @method('POST')
				                <input type="hidden" class="form-control" name="status" value="1"/>
				                <button class="dropdown-item" type="submit">
				                  	<i class="icon mr-2" data-feather="check"></i> Complete IPD
				              	</button>
				            </form>
				            <form method="post" action="{{ route('admin.ipd.complete', $ipd->id) }}">
				                @csrf
				                @method('POST')
				                <input type="hidden" class="form-control" name="status" value="2"/>
				                <button class="dropdown-item" type="submit">
				                  	<i class="icon mr-2" data-feather="x"></i> Cancel IPD
				              	</button>
				            </form>
				            @elseif($ipd->status == 1)
				            <form method="post" action="{{ route('admin.ipd.active', $ipd->id) }}">
				                @csrf
				                @method('POST')
				                <input type="hidden" class="form-control" name="status" value=""/>
				                <button class="dropdown-item" type="submit">
				                  	<i class="icon mr-2" data-feather="check"></i> Active IPD
				              	</button>
				            </form>
				            <form method="post" action="{{ route('admin.ipd.complete', $ipd->id) }}">
				                @csrf
				                @method('POST')
				                <input type="hidden" class="form-control" name="status" value="2"/>
				                <button class="dropdown-item" type="submit">
				                  	<i class="icon mr-2" data-feather="x"></i> Cancel IPD
				              	</button>
				            </form>
				            @elseif($ipd->status == 2)
				            <form method="post" action="{{ route('admin.ipd.active', $ipd->id) }}">
				                @csrf
				                @method('POST')
				                <input type="hidden" class="form-control" name="status" value=""/>
				                <button class="dropdown-item" type="submit">
				                  	<i class="icon mr-2" data-feather="check"></i> Active IPD
				              	</button>
				            </form>
				            <form method="post" action="{{ route('admin.ipd.complete', $ipd->id) }}">
				                @csrf
				                @method('POST')
				                <input type="hidden" class="form-control" name="status" value="1"/>
				                <button class="dropdown-item" type="submit">
				                  	<i class="icon mr-2" data-feather="check"></i> Complete IPD
				              	</button>
				            </form>
				            @endif
				            <a class="dropdown-item" href="{{ route('admin.ipd.show', $ipd->id)}}">
						    	<i class="icon mr-2" data-feather="edit"></i> View
						    </a>
						    <a class="dropdown-item" href="{{ route('admin.ipd.edit', $ipd->id)}}">
						    	<i class="icon mr-2" data-feather="edit"></i> Edit IPD
						    </a>
					    	<form action="{{ route('admin.ipd.destroy', $ipd->id)}}" method="post">
			                  @csrf
			                  @method('DELETE')
			                  <button class="dropdown-item" type="submit">
			                  	<i class="icon mr-2" data-feather="trash-2"></i> Delete IPD
			              	  </button>
			                </form>
						  </div>
						</div>
	                </td>
	        	</tr>
	        	@endforeach
	        </tbody>
	      </table>
	      <div class="row" style="float: right;" align="right">
	      	{{$ipds->links()}}
	      </div>
	    </div>
  	</div>
	@else
	<div align="center">
		There is no IPDs in this month.
	</div>
	@endif



	<div class="page-header mt-5 pt-5">
	    <div class="row">
	    	<div class="col-md-6 col-12 col-xs-12 col-sm-12" align="left">
		    	<h2 class="page-title">opds  <span class="text-muted text-h5 mt-2 pl-2">{{$opds->total()}} items</span></h2>
	    	</div>
	    </div>
	</div>
	@if($opds->count())
	<div class="row">
	    <div class="col-md-12 col-12" style="overflow-x:auto;">
	      <table class="table table-bordered table-hover">
	        <thead>
	          <tr>
	            <th>Patient</th>
	            <th>Phone</th>
	            <th>user</th>
	            <th>Doctor</th>
	            <th>Hospital</th>
	            <th>Fee</th>
	            <th>treatment</th>
	            <th>appointment date</th>
	            <th>appointment time</th>
	            <th>status</th>
	            <th>Action</th>
	          </tr>
	        </thead>
	        <tbody style="padding-bottom: 200px;">
	        	@foreach($opds as $opd)
	        	<tr>
	        		<td>{{$opd->patient}}</td>
	        		<td>{{$opd->phone}}</td>
	        		<td>{{$opd->user->name}}</td>
	        		<td>{{$opd->doctor->name}}</td>
	        		<td>{{$opd->hospital->name}}</td>
	        		<td>{{$opd->fee}}</td>
	        		<td>{{$opd->treatment->name}}</td>
	        		<td><?php $date = date('d-M-Y', strtotime($opd->appointment_date)); echo $date; ?></td>
	        		<td>
	        			<?php $appointment_time = $opd->appointment_time; echo date('h:i a', strtotime($appointment_time)); ?>
	        		</td>
	        		@if($opd->status == NULL)
	        		<td class="badge bg-info" style="margin: 10px auto;display: block;">Active</td>
	        		@elseif($opd->status == 1)
	        		<td class="badge bg-success" style="margin: 10px auto;display: block;">Completed</td>
	        		@elseif($opd->status == 2)
	        		<td class="badge bg-danger" style="margin: 10px auto;display: block;">Cancelled</td>
	        		@endif
	        		<td class="text-center">
	                    <div class="dropdown">
						  <a type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    <i class="icon" data-feather="more-vertical"></i>
						  </a>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						  	@if($opd->status == NULL)
				            <form method="post" action="{{ route('admin.opd.complete', $opd->id) }}">
				                @csrf
				                @method('POST')
				                <input type="hidden" class="form-control" name="status" value="1"/>
				                <button class="dropdown-item" type="submit">
				                  	<i class="icon mr-2" data-feather="check"></i> Complete OPD
				              	</button>
				            </form>
				            <form method="post" action="{{ route('admin.opd.complete', $opd->id) }}">
				                @csrf
				                @method('POST')
				                <input type="hidden" class="form-control" name="status" value="2"/>
				                <button class="dropdown-item" type="submit">
				                  	<i class="icon mr-2" data-feather="x"></i> Cancel OPD
				              	</button>
				            </form>
				            @elseif($opd->status == 1)
				            <form method="post" action="{{ route('admin.opd.active', $opd->id) }}">
				                @csrf
				                @method('POST')
				                <input type="hidden" class="form-control" name="status" value=""/>
				                <button class="dropdown-item" type="submit">
				                  	<i class="icon mr-2" data-feather="check"></i> Active OPD
				              	</button>
				            </form>
				            <form method="post" action="{{ route('admin.opd.complete', $opd->id) }}">
				                @csrf
				                @method('POST')
				                <input type="hidden" class="form-control" name="status" value="2"/>
				                <button class="dropdown-item" type="submit">
				                  	<i class="icon mr-2" data-feather="x"></i> Cancel OPD
				              	</button>
				            </form>
				            @elseif($opd->status == 2)
				            <form method="post" action="{{ route('admin.opd.active', $opd->id) }}">
				                @csrf
				                @method('POST')
				                <input type="hidden" class="form-control" name="status" value=""/>
				                <button class="dropdown-item" type="submit">
				                  	<i class="icon mr-2" data-feather="check"></i> Active OPD
				              	</button>
				            </form>
				            <form method="post" action="{{ route('admin.opd.complete', $opd->id) }}">
				                @csrf
				                @method('POST')
				                <input type="hidden" class="form-control" name="status" value="1"/>
				                <button class="dropdown-item" type="submit">
				                  	<i class="icon mr-2" data-feather="check"></i> Complete OPD
				              	</button>
				            </form>
				            @endif
				            <a class="dropdown-item" href="{{ route('admin.opd.show', $opd->id)}}">
						    	<i class="icon mr-2" data-feather="edit"></i> View
						    </a>
						    <a class="dropdown-item" href="{{ route('admin.opd.edit', $opd->id)}}">
						    	<i class="icon mr-2" data-feather="edit"></i> Edit OPD
						    </a>
					    	<form action="{{ route('admin.opd.destroy', $opd->id)}}" method="post">
			                  @csrf
			                  @method('DELETE')
			                  <button class="dropdown-item" type="submit">
			                  	<i class="icon mr-2" data-feather="trash-2"></i> Delete OPD
			              	  </button>
			                </form>
						  </div>
						</div>
	                </td>
	        	</tr>
	        	@endforeach
	        </tbody>
	      </table>
	      <div class="row" style="float: right;" align="right">
	      	{{$opds->links()}}
	      </div>
	    </div>
  	</div>
	@else
	<div align="center">
		There is no OPDs in this month.
	</div>
	@endif
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
<script type="text/javascript">
	$('table').DataTable();
	$('table').DataTable().order([0, 'desc']).draw();
</script>

@endsection