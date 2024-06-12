

<table   style="" class="table table-sm border-width-2  table-condensed" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr> 
            <th style="" class="col-sm-">Documento</th>
            <th style="" class="col-sm-">Nombres y Apellidos</th>
            <th style="" class="col-sm-">Asignacion</th>  
            <th style="" class="col-sm-">Num Contrato</th>
            <th style="" class="col-sm-">Estado</th>
            <th style="" class="col-sm-1">Opciones</th>   
        </tr>
    </thead>
    <tbody class="table-condensed">
        <?php for ($i = 0; $i < count($this->ConsultaClientesTab); $i++) { ?>
            <tr>
                <td ><?php echo ucwords(strtolower($this->ConsultaClientesTab[$i]['uosDocumento'])); ?></td>
                <td ><?php echo ucwords(strtolower($this->ConsultaClientesTab[$i]['uosNombres'])); ?><?php
                    echo ' ';
                    echo ucwords(strtolower($this->ConsultaClientesTab[$i]['uosApellidos']));
                    ?></td>
                <td ><?php echo ucwords(strtolower($this->ConsultaClientesTab[$i]['uosEstadoContrato'])); ?></td>
                <td ><?php echo ucwords(strtolower($this->ConsultaClientesTab[$i]['cosId'])); ?></td>
                <td class="alert <?php echo $this->ConsultaClientesTab[$i]['cosEstilo']; ?>"><?php echo ucwords(strtolower($this->ConsultaClientesTab[$i]['cosEstado'])); ?></td>                      

            </tr>
        <?php } ?>
        <?php for ($A = 0; $A < count($this->ConsultaClientesTab1); $A++) { ?>
            <tr>
                <td ><?php echo ucwords(strtolower($this->ConsultaClientesTab1[$A]['uosDocumento'])); ?></td>
                <td ><?php
                    echo ucwords(strtolower($this->ConsultaClientesTab1[$A]['uosNombres']));
                    echo ' ';
                    echo ucwords(strtolower($this->ConsultaClientesTab1[$A]['uosApellidos']));
                    ?></td>
                <td ><?php echo ucwords(strtolower($this->ConsultaClientesTab1[$A]['uosEstadoContrato'])); ?></td>
                <td class="alert alert-danger">Por definir</td>
                <td class="alert alert-danger">Por definir</td>                      

            </tr>
        <?php } ?>
    </tbody>
</table>