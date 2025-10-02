class Masterlist extends Main{
    constructor(){
        super()
    }

    DisplayMasterlists(tableElem){

        $.ajax({
            url: "php/controllers/Masterlist/Records.php",
            method: "POST",
            data: {},
            datatype: "json",
            success: function(response){
                // console.log(response);
                let list = response.data;

                list.forEach(function (row) {

                    row.CATEGORY = main.SetRecord(row.CATEGORY);
                });

                var table = new Tabulator(tableElem, {
                    data: list,
                    pagination: "local",
                    paginationSize: 10,
                    paginationSizeSelector: [10, 25, 50, 100],
                    page: 1,
                    ajaxURL: "your_data_endpoint_here.json",
                    layout: "fitDataFill",
                    columns: [
                        {title: "ID", field: "RID", headerFilter: "input"},
                        {title: "DESCRIPTION", field: "DESCRIPTION", headerFilter: "input"},
                        {title: "CATEGORY", field: "CATEGORY", headerFilter: "input"},
                        {title: "CREATED AT", field: "CREATED_AT", headerFilter: "input"},
                        {title: "ACTION", field:"RID", width: 300, hozAlign: "left", headerSort: false, frozen:true, formatter:function(cell){
                            let id = cell.getValue();
                            let edit = '<button class="btn btn-primary btn-minier btnEditRecord" value="'+id+'">Edit</button>';
                            let remove = '<button class="btn btn-danger btn-minier btnRemoveRecord" value="'+id+'">Remove</button>';

                            return edit + " " + remove;
                        }},
                    ],
                });
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
    SetMasterlist(record){
        let self = this;
        $.ajax({
            url: "php/controllers/Masterlist/GetRecord.php",
            method: "POST",
            data: {
                id: record.id,
            },
            datatype: "json",
            success: function(data){
                // console.log(data);
                record.modal.modal("show");
                record.desc.val(data.DESCRIPTION);
                self.PopulateCategory(record.selectCategory, data.CATEGORY)
                record.hiddenID.val(record.id);

                if(record.btnAdd != undefined || record.btnCancel != undefined || record.btnUpdate != undefined){
                    record.btnAdd.hide();
                    record.btnCancel.show();
                    record.btnUpdate.show();
                }
                
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
    PopulateCategory(selectElem, id){
        let list = JSON.parse(localStorage.getItem(this.lsRecordList));
        let options = '<option value="">-Select-</option>';

        for(let i = 0; i < list.length; i++) {
            let selected = "";

            if(id != undefined){
                selected = (list[i].RID == id) ? "selected" : "";
            }
            options += '<option value="'+list[i].RID+'" '+selected+'>'+list[i].DESCRIPTION+'</option>';
        }
        selectElem.html(options);
    }
    InsertMasterlist(record){
        let self = this;
        let desc = record.desc;
        let category = record.category;
        
        if(desc.val() == ""){
            Swal.fire({
                title: 'Incomplete Form.',
                text: 'Please complete the form.',
                icon: 'warning'
            })
        } else {
            $.ajax({
                url: "php/controllers/Masterlist/InsertRecord.php",
                method: "POST",
                data: {
                    desc: desc.val(),
                    category: category.val(),
                },
                success: function(response){
                    console.log(response);
                    response = JSON.parse(response);

                    if(response.status == "duplicate"){

                        Swal.fire({
                            title: 'Duplicate.',
                            text: 'Please input an unique description.',
                            icon: 'warning'
                        })
                    } else if(response.status == "success"){
                        record.modal.modal("hide");
                        record.desc.val("");
    
                        Swal.fire({
                            title: 'Record added successfully!',
                            text: '',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Proceed!',
                            timer: 2000,
                            willClose: () => {
                                self.DisplayMasterlists(record.table);
                            },
                        })
                    }
                    
                },
                error: function(err){
                    console.log("Error:"+JSON.stringify(err));
                },
            });

            //REFRESH RECORD
            this.DisplayMasterlists(record.table);
            
        }
    }
    UpdateMasterlist(record){
        let self = this;
        let desc = record.desc;
        let category = record.category;
        let id = record.id;
        
        if(desc.val() == ""){
            Swal.fire({
                title: 'Incomplete Form.',
                text: 'Please complete the form.',
                icon: 'warning'
            })
        } else {
            $.ajax({
                url: "php/controllers/Masterlist/UpdateRecord.php",
                method: "POST",
                data: {
                    desc: desc.val(),
                    category: category.val(),
                    id: id.val(),
                },
                success: function(response){
                    console.log(response);
                    response = JSON.parse(response);

                    if(response.status == "duplicate"){

                        Swal.fire({
                            title: 'Duplicate.',
                            text: 'Please input an unique description.',
                            icon: 'warning'
                        })
                    } else if(response.status == "success"){

                        record.modal.modal("hide");
                        record.desc.val("");

                        if(record.btnAdd != undefined || record.btnCancel != undefined || record.btnUpdate != undefined){
                            record.btnAdd.show();
                            record.btnCancel.hide();
                            record.btnUpdate.hide();
                        }

                        Swal.fire({
                            title: 'Record updated successfully!',
                            text: '',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Proceed!',
                            timer: 2000,
                            willClose: () => {
                                self.DisplayMasterlists(record.table);
                            },
                        })
                    }
                    
                },
                error: function(err){
                    console.log("Error:"+JSON.stringify(err));
                },
            });

            //REFRESH RECORD
            this.DisplayMasterlists(record.table);
        }
    }
    RemoveMasterlist(record){
        let self = this;
        Swal.fire({
            title: 'Are you sure you want to remove the record?',
            icon: 'question',
            confirmButtonText: 'Yes',
            showCancelButton: true,
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'php/controllers/Masterlist/RemoveRecord.php', // Replace with your server-side script URL
                    type: 'POST',
                    data: {
                        id: record.id,
                    },
                    success: function(response) {
                        // console.log(response);

                        self.DisplayMasterlists(record.table);
                        Swal.fire({
                            title: 'Record removed successfully!',
                            text: '',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Proceed!',
                            timer: 2000,
                            willClose: () => {
                                // window.location.href = "dashboard";
                            },
                        })
            
                    }
                });  
                this.DisplayMasterlists(record.table); 
            }
        })

    }

}