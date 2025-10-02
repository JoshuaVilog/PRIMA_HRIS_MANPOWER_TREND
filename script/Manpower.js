class Manpower extends Main{
    constructor(){
        super()
        this.tableDisplay = null;
    }

    GetEmployeeRecords(callback){

        $.ajax({
            url: "php/controllers/Employee/EmployeeRecords.php",
            method: "POST",
            data: {},
            datatype: "json",
            success: function(response){
                let list = response.data;

                callback(list);
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
    GetTimekeepingRecords(startDate, endDate, callback){

        $.ajax({
            url: "php/controllers/Employee/TimekeepingRecords.php",
            method: "POST",
            data: {
                startDate: startDate,
                endDate: endDate,
            },
            datatype: "json",
            success: function(response){
                let list = response.data;

                callback(list);
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }

    GetManpowerReport(startDate, endDate, callback){
        let deptlist = JSON.parse(localStorage.getItem(this.lsDepartmentList));
        let self = this;

        $("#spinner").show();
        $("#txtStartDate").prop("disabled", true);
        $("#txtEndDate").prop("disabled", true);

        this.GetEmployeeRecords(function(employeeList){
            self.GetTimekeepingRecords(startDate, endDate, function(timekeepingList){
                console.log(timekeepingList);
                employeeList = employeeList.filter(emp => emp.ACTIVE == "1");
                let list = [];
                let dateList = self.GetDateRange(startDate, endDate);
                let columns = [
                    {title: "#", formatter: "rownum", frozen: true,},
                    {title: "DEPT", field: "DEPT", headerFilter: "input", frozen: true,formatter: function(cell){
                        cell.getElement().style.backgroundColor = "#ffffff";
                        return cell.getValue();
                    },},
                    
                ];

                columns.push({
                    title: "TOTAL ACTIVE", 
                    field: "TOTAL_ACTIVE",
                    headerFilter: "input",
                    frozen: true,
                    formatter: function(cell){
                        cell.getElement().style.backgroundColor = "#ffffff";
                        return cell.getValue();
                    },
                });

                for(let index = 0; index < dateList.length; index++){
                    columns.push({
                        title: dateList[index],
                        field: dateList[index],
                        headerFilter: "input",
                    });
                }
                
                for(let i = 0; i < deptlist.length; i++){
                    let deptArray = {};
                    let totalActive = 0;

                    for(let j = 0; j < employeeList.length; j++){
                        if(deptlist[i].DEPARTMENT_ID == employeeList[j].DEPARTMENT_ID){
                            totalActive += 1;
                        }
                    }
                    // TOTAL ACTIVE NA DEPARTMENT
                    if(totalActive > 0){
                        let overallTotalPresent = 0;

                        for(let k = 0; k < dateList.length; k++){
                            let totalPresent = 0;

                            for(let j = 0; j < timekeepingList.length; j++){
                                if((dateList[k] == timekeepingList[j].DATE) && (deptlist[i].DEPARTMENT_ID == timekeepingList[j].DEPT)){
                                    totalPresent += 1;
                                    overallTotalPresent += 1;
                                }
                            }

                            deptArray[dateList[k]] = totalPresent;
                        }

                        deptArray["DEPT"] = deptlist[i].DEPARTMENT_CODE; // insert dept code on array
                        deptArray["TOTAL_ACTIVE"] = totalActive; // insert total present on array
                        deptArray["TOTAL_PRESENT"] = overallTotalPresent; // insert overall total present on array

                    
                        list.push(deptArray);
                    }
                }

                columns.push({
                    title: "OVERALL TOTAL", 
                    field: "TOTAL_PRESENT",
                    headerFilter: "input",
                    frozen: true,
                    formatter: function(cell){
                        cell.getElement().style.backgroundColor = "#ffffff";
                        return cell.getValue();
                    },
                });
                
                
                $("#spinner").hide();
                $("#txtStartDate").prop("disabled", false);
                $("#txtEndDate").prop("disabled", false);

                self.tableDisplay = new Tabulator("#table-records", {
                    data: list,
                    layout: "fitDataFill",
                    columns: columns,
                });

                // callback(list);
            });
        });
    }
    ExportTable(){
        let filename = "Manpower_HeadCount_" + main.GetPhilippinesDateTime()+".xlsx";
        this.tableDisplay.download("xlsx", filename, { sheetName: "Sheet1" });
    }
}