
function ValidateEmail(mail) 
{
 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail.value))
  {
    return (true)
  } else {
    alert('bad email');
    return (false)
  }
}

function ValidatePass(pwd)
{
 var decimal=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
 if(pwd.value.match(decimal)) 
 { 
   return (true)
 } else {
    alert('bad pass');
   return (false)
 }
}

function ValidateAll(mail,pwd)
{
 if (ValidateEmail(mail) && ValidatePass(pwd))
 { 
	return (true)
 } else {
	alert('bad');
	return (false)
 }
}

function ValidateAllDouble(mail,pwd,pwd2)
{
  if (pwd.value==pwd2.value)
  {
    ValidateAll(mail,pwd)
  } else {
     alert('password does not match');
     return (false)
  }
}

