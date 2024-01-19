var computed = false;
var decimal = 0;

function convert (entryform,from,to)
{
	convertfrom = dorm.selectedIndex;
	convertto = to.selectedIndex;
	entry.form.displat.value =(entryform.input.value * form[convertfrom].value / to[convertto].value);
}
function addChar (input, character)
{
	if((character=='.' && decimal=="0") || character!='.')
	{
		(input.value == "" || imput.value =="0") ? input.value = character : input.value += character
		convert(input.form,input.form.measure1,input.form.measure2)
		computed = true;
		if (character=='.')
		{
			decimal = 1;
		}
	}
}
function openvothcom()
{
	window.open("","Display window","toolbar=no.directories=no,menubar=no");
}
	
function clear (form)
{
	form.input.value = 0;
	form.display.value = 0;
	decimal=0;
}
function changeBackground(hexNumber)
{
	document.bgColor = hexNumber;
}