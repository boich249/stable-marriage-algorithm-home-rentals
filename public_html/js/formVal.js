

// Constructor for the validator object
function Validator(name, title, regexp, validateField){
    this.name = name;
    this.title = title;
    this.regexp = regexp;
    this.validateField = validateField;
   }
    
 // Create and store all the validators as objects in an array   
 var validators = [];
    
    validators[0] = new Validator("fname", "Name", /^[a-zA-Z-]+$/, function(field){
        return this.regexp.test(field.value);
    });
    
    validators[1] = new Validator("lname", "Name", /^[a-zA-Z-]+$/, function(field){
        return this.regexp.test(field.value);
    });
    
    validators[2] = new Validator("phone", "Phone Number", /^\(\d{3}\)\d{3}-\d{4}/, function(field){
        return this.regexp.test(field.value);
    });
    
    validators[3] = new Validator("email", "Email", /^[a-zA-Z\d]*@[a-zA-Z\d]*\.[a-zA-Z]{2,4}/, function(field){
        return this.regexp.test(field.value);
    });
    
    validators[4] = new Validator("username", "User Name", /^[\dA-Za-z]{6,}$/, function(field){
        return this.regexp.test(field.value);
    });
    
    validators[5] = new Validator("psw1", "Password", /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/, function(field){
        var psw2 = document.getElementById("psw2");
        var psw2msg = psw2.parentNode.lastChild.class;
        if (psw2msg === "warn" || psw2msg === "ok")
            validate(psw2);
        return this.regexp.test(field.value);
    });
    
    validators[6] = new Validator("psw2", "Retyped Password", /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/, function(field){
        var psw1 = document.getElementById("psw1").value;
        return (field.value === psw1 && this.regexp.test(psw1) && this.regexp.test(field.value));
    });
    
    validators[7] = new Validator("postal", "Postal Code", /^[a-zA-Z]\d[a-zA-Z]( )?\d[a-zA-Z]\d$/, function(field){
        return this.regexp.test(field.value);
    });
    
    validators[8] = new Validator("number", "Number", /^\d*\.?\d+$/, function(field){
        return this.regexp.test(field.value);
    });
    
   
// Finds the right validator for the field    
function findValidator(name){
    
    for (var i = 0; i < validators.length; i++)
        if (name === validators[i].name)
            return validators[i];
            
}

// Validates the field
function validate(field){
    var validator = findValidator(field.name);
    if (validator.validateField(field)){
        validDisp(field, validator.title);
        return true;
    }
    else if (!validator.validateField(field)){
        invalidDisp(field, validator.title);
        return false;
    }
}

function validateAll(form){
    for(var i = 0; i < form.length; i++ ){
        for (var j = 0; j < validators.length; j++){
            if (form[i].name === validators[j].name){
                var validator = validators[j];
                if (!validator.validateField(form[i])){
                    return false;
                }
                break;
            }
        }
    }
    return true;
}



/*******************************************************************************
 * The following functions display a message concerning the validity of the field
 *****************************************************************************/


// Displays a customized invalid message
function invalidDisp(field, title){
   var par = field.parentNode;
   if(par.lastChild.class !== "warn" && par.lastChild.class !== "ok"){
       var msg = document.createElement("P");
       var msgtxt = document.createTextNode("Invalid " + title);
       msg.appendChild(msgtxt);
       msg.class = "warn";
       msg.style.color = "red";
       msg.style.display = "inline";
       par.appendChild(msg);
      
   }
   else if (par.lastChild.class === "ok"){
       par.lastChild.style.color = "red";
       par.lastChild.class = "warn";
       par.lastChild.innerHTML = "Invalid " + title;
   }
}

// Displays a customized valid message
function validDisp(field, title){
   var par = field.parentNode;
   if(par.lastChild.class !== "warn" && par.lastChild.class !== "ok"){
       var msg = document.createElement("P");
       var msgtxt = document.createTextNode(title + " Okay");
       msg.appendChild(msgtxt);
       msg.class = "ok";
       msg.style.color = "green";
       msg.style.display = "inline";
       par.appendChild(msg);
   }
   else if (par.lastChild.class === "warn"){
       par.lastChild.style.color = "green";
       par.lastChild.class = "ok";
       par.lastChild.innerHTML = title + " Okay";
   }
}

// Enables a disabled field on the click of a checkbox/radio button
function enableField(fieldId, clicked){
    var toEnable = document.getElementById(fieldId);
    if (clicked.checked === true){
        toEnable.disabled = false;
    }
    else
        toEnable.disabled = true;
}

// Makes sure min values are below max values
function minBelowMax(minId, maxId){
    var max = document.getElementById(maxId);
    var min = document.getElementById(minId);
    if (max.disabled === true || min.disabled === true || parseInt(max.value) >= parseInt(min.value)){
       if (max.parentNode.lastChild.class === "warn")
           max.parentNode.removeChild(max.parentNode.lastChild);
    }
    else
       invalidDisp(max, "");

}
