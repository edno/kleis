/**
 * @source https://www.404it.no/en/blog/javascript_random_password_generator
 */

// Public: Constructor
var RandomPassword = function () {
	this.chrLower="abcdefghjkmnpqrst";
	this.chrUpper="ABCDEFGHJKMNPQRST";
	this.chrNumbers="23456789";
	this.chrSymbols="!#%&?+*_.,:;";

	this.maxLength=255;
	this.minLength=4;
}

/*
	Public: Create password

	length (optional): Password length. If value is not within minLength/maxLength (defined in constructor), length will be adjusted automatically.

	characters (optional): The characters the password will be composed of. Must contain at least one of the following:
		this.chrLower
		this.chrUpper
		this.chrNumbers
		this.chrSymbols
	Use + to combine. You can add your own sets of characters. If not at least one of the constructor defined sets of characters is found, default set of characters will be used.
*/
RandomPassword.prototype.create = function(length, characters) {
	var _length=this.adjustLengthWithinLimits(length);
	var _characters=this.secureCharacterCombination(characters);

	return this.shufflePassword(this.assemblePassword(_characters, _length));
};

// Private: Adjusts password length to be within limits.
RandomPassword.prototype.adjustLengthWithinLimits = function(length) {
	if(!length || length<this.minLength)
		return this.minLength;
	else if(length>this.maxLength)
		return this.maxLength;
	else
		return length;
};

// Private: Make sure characters password is build of contains meaningful set of characters.
RandomPassword.prototype.secureCharacterCombination = function(characters) {
	var defaultCharacters=this.chrLower+this.chrUpper+this.chrNumbers;

	if(!characters || this.trim(characters)=="")
		return defaultCharacters;
	else if(!this.containsAtLeast(characters, [this.chrLower, this.chrUpper, this.chrNumbers, this.chrSymbols]))
		return defaultCharacters;
	else
		return characters;

};

// Private: Assemble password using a string of characters the password will consist of.
RandomPassword.prototype.assemblePassword = function(characters, length) {
	var randMax=this.chrNumbers.length;
	var randMin=randMax-4;
	var index=this.random(0, characters.length-1);
	var password="";

	for(var i=0; i<length; i++) {
		var jump=this.random(randMin, randMax);
		index=((index+jump)>(characters.length-1)?this.random(0, characters.length-1):index+jump);
		password+=characters[index];
	}

	return password;
};

// Private: Shuffle password.
RandomPassword.prototype.shufflePassword = function(password) {
	return password.split('').sort(function(){return 0.5-Math.random()}).join('');
};

// Private: Checks if string contains at least one string in an array
RandomPassword.prototype.containsAtLeast = function(string, strings) {
	for(var i=0; i<strings.length; i++) {
		if(string.indexOf(strings[i])!=-1)
			return true;
	}
	return false;
};

// Private: Returns a random number between min and max.
RandomPassword.prototype.random = function(min, max) {
	return Math.floor((Math.random() * max) + min);
};

// Private: Trims a string (required for compatibility with IE9 or older)
RandomPassword.prototype.trim = function(s) {
	if(typeof String.prototype.trim !== 'function')
		return s.replace(/^\s+|\s+$/g, '');
	else
		return s.trim();
};
