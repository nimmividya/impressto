//ezEditTable configuration object          
var ezConfig = {
    editable: true,
    auto_save: true,
    default_selection: 'both',
    editor_model: 'cell',
    cell_editors:[
        { type: 'none' },
        { type: 'input', attributes:[['title', 'First name and last name']] },
        { type: 'input', attributes:[['title', 'email address']] },
        { type: 'custom', target: 'datePick' },
        { type: 'input', attributes:[['maxLength', 10], ['title', '10 digits max.\n numbers with 2 decimal places only']], css:'alignRight' },
        { type: 'boolean' }
    ],
    actions:{
        'update': { 
            uri: 'php/employeeUpdateXhr.php', form_method: 'POST',
            on_update_submit: function(o, rows){
                o.config.exec_requests(o, rows, 'update');
            },
            param_names: ['id','name','email','startdate','salary','active'],
            //additional custom properties for ajax_request
            ajaxContId: 'divAjaxOpsCont', ajaxId: 'divAjaxOps'
        },
        'insert': { 
            uri: 'php/employeeInsertXhr.php', form_method: 'POST', 
            on_insert_submit: function(o, rows){
                o.config.exec_requests(o, rows, 'insert');
            },
            param_names: ['id','name','email','startdate','salary','active'],
            default_record: ['', 'Employee name...', 'employee@email.com', '2011-01-01','0', '<input type="checkbox" checked>'],
            //additional custom properties for ajax_request
            ajaxContId: 'divAjaxOpsCont', ajaxId: 'divAjaxOps'
        },
        'delete': { 
            uri: 'php/script.deleteEmployee.php', submit_method: 'script', bulk_delete: false,
            param_names: ['id']
        }
    },
     
    /************************************************************
        CUSTOM DELEGATE METHOD FOR INSERT AND UPDATE OPERATIONS
    *************************************************************/
    exec_requests: function(o, rows, dbAction){
        var action = o.config.actions[dbAction]; //config object: actions.insert or actions.update 
        var cont = o.Get(action.ajaxContId); //messages container element
 
        for(var i=0; i<rows.length; i++){
            var r = rows[i];
            var rowIndex = r[0];
            var rowId = o.table.rows[rowIndex].getAttribute('id');
            var rowObj = r[1]; //ezEditTable row object
            var rowValues = rowObj.values; //values prop returns array with cell values
            var params = '';
             
            //parameters object is constructed below 
            for(var j=0; j<rowValues.length; j++){
                params += o[dbAction+'Params'][j] + '=' + encodeURIComponent(rowValues[j]) + '&';
            }
            params += 'rIndex=' + rowIndex + '&rowId=' + rowId;
 
            var div = o.CreateElm('div', ['id', 'div_r'+rowIndex]);
            cont.appendChild(div);
            $('#'+action.ajaxId).show('slow');
             
            var c = 0; //successful requests counter
             
            //jQuery Ajax request
            var xhr = $.ajax({
              url: action.uri,
              context: $('#'+div.id),
              type: action.form_method,
              data: params,
              dataType: 'html'
            })
            .done(function(data) { 
                this.html(data);
                if(rowIndex){ //Modified cell mark is removed
                    o.Editable.RemoveModifiedCellMark(rowIndex);
                    c++;
                }
                if(c==rows.length){ 
                //action requests completed, ezEditTable array re-initialized
                    if(dbAction === 'update'){ o.Editable.modifiedRows = []; }
                    if(dbAction === 'insert'){
                        o.Editable.newRows = [];
                        o.Editable.addedRows = [];
                        $(o.table.rows).removeClass(o.newRowClass);
                    }
                }
            })
            .fail(function(jqXHR, textStatus){
                cont.innerHTML = 'Ouups an error occured! Data could not be updated!<br>'+textStatus;
            });
        }
    },
    /************************************************************/
     
    //Data validation delegate, the script does not provide data validation tools
    validate_modified_value: function(o, colIndex, oldVal, newVal, cell, editor){
        if(colIndex==2 && oldVal != newVal){ 
            if(!et_ValidateEmail(newVal)){
                alert('Please insert a valid email!'); 
                return false;
            } else return true;
        }
        else if(colIndex == 4 && oldVal != newVal){
            if(!et_IsNumber(newVal)){
                alert('Please insert a valid number with 2 decimal places!');
                return false;
            } else return true;
        }
        else return true;
    },
    //Custom editor functions
    open_custom_editor: function(o, cell, editor){
        if(cell.cellIndex == 3){ 
            if(editor.innerHTML == '') setPickerDate();
            //properties added for date picker onselected delegate (setOnSelectedDelegate)
            datePicker.eg_obj = o; 
            datePicker.eg_cell = cell;
            datePicker.eg_editor = editor;
        } else cell.innerHTML = '';
        cell.appendChild(editor);
        editor.style.display = ''; 
    },
    close_custom_editor: function(o, cell, editor){ 
        if(cell.cellIndex == 3){
            editor.style.display = 'none';
            document.body.appendChild(editor);
        }
    },
    //We define here how to retrieve the custom editor value
    get_custom_editor_value: function(o, editor, colIndex){
        var strDate;
        if(colIndex == 3){//Date picker
            var obj = datePicker.getSelectedDay();
            var m = (obj.month.toString().length==1 ? '0' + obj.month : obj.month);
            var d = (obj.day.toString().length==1 ? '0' + obj.day : obj.day);
            strDate = obj.year+'-'+m+'-'+d;
        }               
        return strDate;
    },
    //We define here how to set the custom editor value
    set_custom_editor_value: function(o, editor, colIndex, val){
        if(colIndex == 3){ 
            var date = et_FormatDate(val, 'YMD');
            datePicker.setSelectedDay({ year:parseInt(date.getFullYear()), month:parseInt(date.getMonth()+1), day:parseInt(date.getDate()) });
        }
    }
}