<!-- MODAL -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">Cerrar</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="fetched-data"></div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL -->
<div class="container">
		<div class="col-md-3">
			<div class="panel panel-default">
			  <div class="panel-body">			  
			    <form  action="index.php?s=classifieds" method="GET" id="searchPclave">
	            <label class="filter_txt" for="w">Filtrar por palabra</label>
			            <div class="form-group">
			              <input type="text" style="width:100%; background-color:#F2F2F2;" size="22" class="form-control input-sm" id="palabra" name="palabra" placeholder="Departamento, casa, terreno ...">
			            </div>
			            <div style="margin-top:6px;">
			            <div class="form-group">
			             <label class="filter_txt" for="w">Seleccione Región</label>
			                   <select style="width:100%; background-color:#F2F2F2" id="regiones" name="region" class="form-control" id="region"></select>
			             </div>
			        	 <div class="form-group">
			        	    <label class="filter_txt" for="w">Seleccione Ciudad</label>
		                   <select style="width:100%; background-color:#F2F2F2" id="comunas" name="comuna" class="form-control" ></select>
		              	</div>
		              	<div class="form-group">
							<label class="filter_txt" for="w">Tipo de Inmueble</label>
							<select style="width:100%; background-color:#F2F2F2" name="tipo_inmueble" id="tipo_inmueble" class="form-control">
								<option value="">Seleccione Tipo</option>
								<option value="0">Departamento</option>
								<option value="1">Casa</option>
								<option value="2">Oficina</option>
								<option value="3">Comercial e industrial</option>
								<option value="4">Terreno</option>
								<option value="5">Estacionamiento, bodega u otro</option>
								<option value="6">Pieza</option>
							</select>
						</div>
						<hr>
						<div class="form-group">
							<select name="precioMin" id="precioMin"  style="width:100%; background-color:#F2F2F2" class="form-control">
							<option value="" selected="selected">Precio mín</option>
								<option value="0">$ 0</option>
								<option value="1">$ 50.000</option>
								<option value="2">$ 100.000</option>
								<option value="3">$ 150.000</option>
								<option value="4">$ 200.000</option>
								<option value="5">$ 250.000</option>
								<option value="6">$ 300.000</option>
								<option value="7">$ 350.000</option>
								<option value="8">$ 400.000</option>
								<option value="9">$ 450.000</option>
								<option value="10">$ 500.000</option>
								<option value="11">$ 550.000</option>
								<option value="12">$ 600.000</option>
								<option value="13">$ 650.000</option>
								<option value="14">$ 700.000</option>
								<option value="15">$ 750.000</option>
								<option value="16">$ 800.000</option>
								<option value="17">$ 850.000</option>
								<option value="18">$ 900.000</option>
								<option value="19">$ 950.000</option>
								<option value="20">$ 1.000.000</option>
								<option value="21">$ 1.250.000</option>
								<option value="22">$ 1.500.000</option>
								<option value="23">$ 1.750.000</option>
								<option value="24">$ 2.000.000</option>
								<option value="25">$ 2.500.000</option>
								<option value="26">$ 3.000.000</option>
								<option value="27">$ 4.000.000</option>
								<option value="28">$ 5.000.000</option>
								<option value="29">$ 10.000.000</option>
						</select>
						</div>
						<div class="form-group" style="margin-top:3px;">
							<select name="precioMax" id="precioMax" style="width:100%; background-color:#F2F2F2" class="form-control">
								<option value="" selected="selected">Precio máx</option>
								<option value="1">$ 50.000</option>
								<option value="2">$ 100.000</option>
								<option value="3">$ 150.000</option>
								<option value="4">$ 200.000</option>
								<option value="5">$ 250.000</option>
								<option value="6">$ 300.000</option>
								<option value="7">$ 350.000</option>
								<option value="8">$ 400.000</option>
								<option value="9">$ 450.000</option>
								<option value="10">$ 500.000</option>
								<option value="11">$ 550.000</option>
								<option value="12">$ 600.000</option>
								<option value="13">$ 650.000</option>
								<option value="14">$ 700.000</option>
								<option value="15">$ 750.000</option>
								<option value="16">$ 800.000</option>
								<option value="17">$ 850.000</option>
								<option value="18">$ 900.000</option>
								<option value="19">$ 950.000</option>
								<option value="20">$ 1.000.000</option>
								<option value="21">$ 1.250.000</option>
								<option value="22">$ 1.500.000</option>
								<option value="23">$ 1.750.000</option>
								<option value="24">$ 2.000.000</option>
								<option value="25">$ 2.500.000</option>
								<option value="26">$ 3.000.000</option>
								<option value="27">$ 4.000.000</option>
								<option value="28">$ 5.000.000</option>
								<option value="29">$ 10.000.000</option>
								<option value="30">$ 20.000.000 o  más</option>
						</select>
						</div>
				      <div style="margin-top:10px;">
			          <button type="submit" style="width:100%;" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true" id="search-"></i> Buscar</button>
			          </div>
					</form>
			  	</div>
			</div>
		</div>		
	</div>
	<div class="col-md-9">
			<div class="panel panel-default">
          		<div class="panel-body">
	          		<div class="table-responsive">
	            			<div id="central">
					            <div id="content"><?php require('includes/pagination.php');?></div>
					        </div>
					</div>
           		 </div> 
            <!-- Fin Productos -->            
		</div> 
	</div>
