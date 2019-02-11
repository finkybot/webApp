// JavaScript source code 
// Author K.Abraham 
// 22-11-2016

// some methods are taken or adopted from TT284 Block 2 Part 3
/** function selectionMade(anId, aChoice) 
 *  ensure a selction is made from the available choices
 */
function selectionMade(anId, aChoice)
{
    if(anId.value == aChoice)
    {
        return "Please choose one of the available options\n";
    }
    else
    {
        return "";
    }
}

/** function checkLength(value, min, max)
 *  check a value length is between and inclusive of a min and max value
 */
function checkLength(value, min, max)
{
    if(value.length >= min && value.length <= max)
    {
        return "";
    }
    else
    {
        return ("Please ensure character length is\n more than or equal to " + min + "\n" 
                + "and less than or equal to " + max);
  
    }
}

/** function trim(aString) 
 *  remove leading edge whitespaces from the string
*/
function trim(aString)
{
    return aString.replace(/^\s+|\s+$/,'');
}

/**
 * function isEmpty(aString, aName)
 * return true if string is empty or false if not
 */
function isEmpty(aString)
{
    if (aString == null || aString == "")
    {
        return true;
    }
    else
    {
        return false;
    }
}

/** function validString(anId,aPattern, isAllowed)
 *  check the input data from the element anId is 
 *  empty and allowed to be empty or not (isAllowed)
 *  if it's not empty then test data 
 *  meets the desired regular expression (aPattern)      
**/
function validString(anId, aPattern, isAllowed)
{

    // get string from form and set pattern
    var aString = document.getElementById(anId).value;
     
    // trim any edge whitespaces
    aString = trim(aString);
    // check if the string is empty if it is then test if it is allowed to 
    // be empty returning false if it is not allowed, true otherwise
    if(isEmpty(aString))
    {
        if(isAllowed) // no error empty input allowed, return true
        {
            return true;
        }
        else // error return false
        {
            return false;
        }

    }   
    else // if there is data then validate it
    {
        // test the value in the string is valid
        if (aPattern.test(aString))
        {
            return true; // test passed no error
        }
        else
        {
            return false;
        }
    }
}

/** function validateForm() 
 *  encapsulates the checking of the the running club form
 */
function validateForm()
{
    // number only pattern from 1 - 9999
    var numPatFour = /^(?:[1-9][0-9]{3}|[1-9][0-9]{2}|[1-9][0-9]|[1-9])$/;
    // number only pattern from 1 - 99 also including 100
    var numPatTwo = /^([1-9]{1}|[0-9]{2})$|100/;
    // percentage pattern with two decimal places of any value from 0 to 99.99 or 100 (note 100.00 will also be accepted)
    var percPatTwoDp = /^(\d{0,2}(\.\d{1,2})?|100(\.00?)?)$/;
    // text only pattern
    var alphaPat = /^[a-zA-Z]+$/;
    // binary pattern accepts 0 or 1
    var binPat = /^[0-1]$/;
    // time pattern for hh-mm-ss leading zeros are mandatory (24 hour clock) note any time up to 24 hours can be given
    var timePat = /^(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/;

    // note the next two patterns are based on research and examining  of comparable regular expressions see see http://regexlib.com 
    // email pattern based on RFC 5322 see http://emailregex.com/email-validation-summary/ i think this is compatable
    var emailPat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    
    // date pattern: this pattern will work with any date in the 2000s+ also counts leap year dates correctly.... im not sure if there is an easier way of doing this....this was painfull......
    var datePat = /^((((2[0-9][0-9][0-9]))([-])(0[13578]|10|12)([-])(0[1-9]|[12][0-9]|3[01]))|(((2[0-9][0-9][0-9]))([-])(0[469]|11)([-])([0][1-9]|[12][0-9]|30))|(((2[0-9][0-9][0-9]))([-])(02)([-])(0[1-9]|1[0-9]|2[0-8]))|(([02468][048]00)([-])(02)([-])(29))|(([13579][26]00)([-])(02)([-])(29))|(([0-9][0-9][0][48])([-])(02)([-])(29))|(([0-9][0-9][2468][048])([-])(02)([-])(29))|(([0-9][0-9][13579][26])([-])(02)([-])(29)))$/;


    // create an error variable result and check each of the input elements to see if data is valid, build a string of any errors
    // that will be used to alert the user
    var result = ""
    if(!validString('RunnerID', numPatFour, false))
    {
        result = result + "ERROR: Runner ID must contain a valid numeric value from 1 - 9999\n";
    }

    if(!validString('EventID', numPatFour, false))
    {
        result = result + "ERROR: Event ID must contain a valid numeric value from 1 - 9999\n";
    }
    
    if(!validString('Date', datePat, false))
    {
        result = result + "ERROR: Date must contain a valid date in yyyy-mm-dd format\n";
    }

    if(!validString('FinishTime', timePat, false))
    {
        result = result + "ERROR: Finish Time must contain a valid time in hh-mm-ss format\n";
    }

    if(!validString('Position', numPatFour, true))
    {
        result = result + "ERROR: Position does not contain a  valid numeric value,\nthis field may be empty or contain a value from 1 - 9999\n";
    }

    if(!validString('CategoryID', numPatTwo, true))
    {
        result = result + "ERROR: Category ID does not contain a valid numeric value,\nthis field may be empty or contain a value from 1 - 100\n";
    }

    if(!validString('AgeGrade', percPatTwoDp, true))
    {
        result = result + "ERROR: Age grade does not contain a valid numeric value,\nthis field may be empty or contain a value from 0.00 - 100\n";
    }
    if(!validString('PB', binPat, true))
    {
        result = result + "ERROR: Personal Best accepts a binary value, either 0 or 1";
    }
    // check if any errors have been generated and alert the user to these, returns false stopping the procesing of the data
    if (result != "") {
        alert(result);
        return false;
    }
    return; // data good continue
}
