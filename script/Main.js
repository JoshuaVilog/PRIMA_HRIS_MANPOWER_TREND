
class Main {

    constructor(){
        this.systemLocalStorageTitle = "manpower";
        this.lsEmployeeList = this.systemLocalStorageTitle +"-employee-list";
        this.lsDepartmentList = this.systemLocalStorageTitle +"-department-list";
        this.lsRecordList = this.systemLocalStorageTitle +"-record-list";

    }

    GetCurrentDate(numMinus){
        let currentDate = new Date();
        let year = currentDate.getFullYear();
        let month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-indexed
        let day = (numMinus == undefined)? currentDate.getDate().toString().padStart(2, '0') : currentDate.getDate().toString().padStart(2, '0') - numMinus;
        let formattedDate = `${year}-${month}-${day}`;

        // Outputs something like: 2024-05-29
        return formattedDate;
    }

    GetPhilippinesDateTime(){
        const options = {
            timeZone: "Asia/Manila", 
            year: "numeric", 
            month: "2-digit", 
            day: "2-digit", 
            hour: "2-digit", 
            minute: "2-digit", 
            second: "2-digit",
            hour12: false
        };
    
        const formatter = new Intl.DateTimeFormat("en-US", options);
        const parts = formatter.formatToParts(new Date());
    
        // Format to YYYY-MM-DD HH:MM:SS
        const year = parts.find(p => p.type === "year").value;
        const month = parts.find(p => p.type === "month").value;
        const day = parts.find(p => p.type === "day").value;
        const hour = parts.find(p => p.type === "hour").value;
        const minute = parts.find(p => p.type === "minute").value;
        const second = parts.find(p => p.type === "second").value;
    
        return `${year}-${month}-${day} ${hour}:${minute}:${second}`;
    }

    GetDateOnly(datetime){
        return datetime.split(' ')[0];
    }

    GetDurationMinutes(IN, OUT) {
        if (IN == null || OUT == null) {
            return 0;
        } else {
            // Parse the input strings into Date objects
            const inDate = new Date(IN);
            const outDate = new Date(OUT);
            
            // Calculate the difference in milliseconds
            const diffMs = outDate - inDate;
            
            // Convert milliseconds to minutes (with decimals)
            const diffMinutes = diffMs / 60000; // 1 minute = 60,000 ms
            
            return diffMinutes.toFixed(2);
        }
    }
    GetDateRange(startDate, endDate) {
        const result = [];
        const current = new Date(startDate);
      
        while (current <= new Date(endDate)) {
          // format as YYYY-MM-DD
          const formatted = current.toISOString().split("T")[0];
          result.push(formatted);
      
          // add 1 day
          current.setDate(current.getDate() + 1);
        }
      
        return result;
    }

    //================================================================================//

    GetEmployeeRecords(){
        let self = this;
        $.ajax({
            url: "php/controllers/Employee/EmployeeRecords.php",
            method: "POST",
            data: {},
            datatype: "json",
            success: function(response){
                // console.log(response);
                let list = response.data;

                localStorage.setItem(self.lsEmployeeList, JSON.stringify(list));
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
    GetDepartmentRecords(){
        let self = this;
        $.ajax({
            url: "php/controllers/Employee/DepartmentRecords.php",
            method: "POST",
            data: {},
            datatype: "json",
            success: function(response){
                // console.log(response);
                let list = response.data;

                localStorage.setItem(self.lsDepartmentList, JSON.stringify(list));
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
    GetRecordRecords(){
        let self = this;
        $.ajax({
            url: "php/controllers/Record/Records.php",
            method: "POST",
            data: {},
            datatype: "json",
            success: function(response){
                // console.log(response);
                let list = response.data;

                localStorage.setItem(self.lsRecordList, JSON.stringify(list));
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }

    
    SetEmployeeNameByID(id){
        let list = JSON.parse(localStorage.getItem(this.lsEmployeeList));
        
        if(id == 1){
            return "SYSTEM ADMIN"
        } else {
            let result = list.find(element => element.EMPLOYEE_ID === id);

            return result ? result.EMPLOYEE_NAME: "";
        }
    }

    SetEmployeeNameByRFID(id){
        let list = JSON.parse(localStorage.getItem(this.lsEmployeeList));
        
        if(id == "ADMIN"){
            return "SYSTEM ADMIN";
        } else {
            let result = list.find(element => element.RFID === id);

            return result ? result.EMPLOYEE_NAME: "";
        }
    }
    SetDeptCodeByBioUserID(id){
        let list = JSON.parse(localStorage.getItem(this.lsEmployeeList));
        if(id == "ADMIN"){
            return "SYSTEM ADMIN";
        } else {
            let result = list.find(element => element.BIO_USER_ID === id);

            return result ? result.DEPARTMENT_ID: "";
        }
    }
    SetRecord(id){
        let list = JSON.parse(localStorage.getItem(this.lsRecordList));
        
        if(id == 1){
            return "SYSTEM ADMIN"
        } else {
            let result = list.find(element => element.RID === id);

            return result ? result.DESCRIPTION: "";
        }
    }

    PopulateSelectAddRecord(elements, data){
        let select = elements.selectElem;
        let txtAdd = elements.txtAdd;
        let btnAdd = elements.btnAdd;
        let btnSave = elements.btnSave;
        let btnCancel = elements.btnCancel;

        data.populateSelect(select)

        btnAdd.click(function(){
            btnAdd.hide();
            btnSave.show();
            btnCancel.show();
            txtAdd.show();
            select.hide();
            select.val("");
            txtAdd.val("");

        });

        btnCancel.click(function(){
            btnAdd.show();
            btnSave.hide();
            btnCancel.hide();
            txtAdd.hide();
            select.show();
            select.val("");
            txtAdd.val("");
        })

        btnSave.click(function(){
            if(txtAdd.val() != ""){

                data.insertRecord({desc: txtAdd }, function(response){
                    let id = response.id;
                    
                    data.getRecords();
                    
                    setTimeout(() => {
                        data.populateSelect(select, id);
                        
                        btnAdd.show();
                        btnSave.hide();
                        btnCancel.hide();
                        txtAdd.hide();
                        select.show();

                    }, 500);
                });
            }
        }); 
    }


    //////////////////////////////////////////////////////

    CheckUserAccess(){
        $.ajax({
            url: "php/controllers/User/CheckUserAccess.php",
            method: "POST",
            data: {},
            success: function(response) {
                console.log(response);

                if(response == null){
                    //Alert No access then proceed to dashboard
                    Swal.fire({
                        title: 'No access!',
                        text: 'Please contact the administrator to grant access.',
                        icon: 'warning'
                    }).then(() => {
                        window.location.href = "dashboard";
                    });
                }
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
}


let main = new Main();

main.GetEmployeeRecords();
main.GetRecordRecords();
main.GetDepartmentRecords();