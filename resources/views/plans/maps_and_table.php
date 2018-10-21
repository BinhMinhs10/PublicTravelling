
        <div class="row outside_title_map_and_guide" >
            <div class="col-md-8 text-center title_maps_and_guide bodright" >Map</div>
            <div class="col-md-4 text-center title_maps_and_guide bodleft" >Guide</div>
        </div>
        <div class="row custom_margin_map">
            <div class="col-md-8" id="map" ></div>
            <div class="col-md-4" id="right-panel"></div>
        </div>
        <div class="row custom_margin_table"> 
        <div class="col-md-12">
        <form id="routeForm">      
            <table id="routes" class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Marker Start</th>
                        <th>Time Start</th>
                        <th>Marker End</th>
                        <th>Time End</th>
                        <th>Vehicle</th>
                        <th>Activities</th>
                        <th></th>
                        <th></th>
                    </tr>   
                </thead>
                <tr>
                    <td>
                        <input id="start1" class="form-control" type="text" name="start1" autocomplete="off" ></input>
                    </td>
                    <td>
                        <input id="timeStart1" class="form-control" type="text" name="timeStart1" autocomplete="off"></input>
                    </td>
                    <td>
                        <input id="finis1" class="form-control" type="text" name="finis1" autocomplete="off"></input>       
                    </td>
                    <td>
                        <input id="timeEnd1" class="form-control" type="text" name="timeEnd1" autocomplete="off"></input>
                    </td>
                    <td>
                        <div class="my_dropdown_list">
                            <select class="form-control" 
                            onchange="dropdownForVehicle(this,1);">
                                <option></option>
                                <option value="Motorbike">Motorbike</option>
                                <option value="Car">Car</option>
                                <option value="Bus">Bus</option>
                            </select>
                            <input class="form-control my_dropdown_box" type="text" name="displayValueVehicle1" id="displayValueVehicle1"placeholder="Enter/Select a vehicle" onfocus="this.select()" >
                            <input name="vehicle1" id="vehicle1" type="hidden">
                        </div>
                    </td>
                    <td>
                        <div class="my_dropdown_list">
                            <select class="form-control" 
                            onchange="dropdownForActivities(this,1);">
                                <option></option>
                                <option value="Move">Move</option>
                                <option value="Take photo">Take photo</option>
                                <option value="Camping">Camping</option>
                            </select>
                            <input class="form-control my_dropdown_box" type="text" name="displayValueActivities1" id="displayValueActivities1" placeholder="Enter/Select an activity" onfocus="this.select()">
                            <input name="activities1" id="activities1" type="hidden">
                        </div>
                    </td>
                    <td><i id="addRow1" class="fa fa-plus custom_fa"  onclick="addRow(this)" name="addRow1"></i></td>
                    <td><i id="delRow1" class="fa fa-minus custom_fa"  onclick="delRow(this)" name="delRow1"></i></td>

                </tr>
            </table>
        </form>
        </div>
        </div>

        <div class="row martop30">
            <div class="col-md-1 offset-7">
                <button id="endPlanButton" class="btn btn-primary"  onclick="endPlan();">
                    End Plan
                </button>
            </div>
            <div class="col-md-2">
                <button id="undoEndPlanButton" class="btn btn-primary"  onclick="undoEndPlan();">
                    Undo End Plan
                </button>
            </div>            
            <div class="col-md-1">
                <button id="createPlanButton" class="btn btn-primary">
                    Save Plan
                </button>
            </div>
        </div>        