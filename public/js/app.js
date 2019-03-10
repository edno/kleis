/**
 * @source http://stackoverflow.com/questions/400212/how-do-i-copy-to-the-clipboard-in-javascript/33928558#33928558
 */

// Copies a string to the clipboard. Must be called from within an event handler such as click.
// May return false if it failed, but this is not always
// possible. Browser support for Chrome 43+, Firefox 42+, Edge and IE 10+.
// No Safari support, as of (Nov. 2015). Returns false.
// IE: The clipboard feature may be disabled by an adminstrator. By default a prompt is
// shown the first time the clipboard is used (per session).
function copyToClipboard(text) {
    if (window.clipboardData && window.clipboardData.setData) {
        // IE specific code path to prevent textarea being shown while dialog is visible.
        return clipboardData.setData("Text", text);

    } else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
        var textarea = document.createElement("textarea");
        textarea.textContent = text;
        textarea.style.position = "fixed";  // Prevent scrolling to bottom of page in MS Edge.
        document.body.appendChild(textarea);
        textarea.select();
        try {
            return document.execCommand("copy");  // Security exception may be thrown by some browsers.
        } catch (ex) {
            console.warn("Copy to clipboard failed.", ex);
            return false;
        } finally {
            document.body.removeChild(textarea);
        }
    }
}

/*** Kleis Account Generator ***/

var KleisAccount = function (chunkLen, saltLen) {
	this.minLength = 3;

    if(!chunkLen || chunkLen<this.minLength) {
        this.chunkLen = this.minLength;
    } else {
        this.chunkLen = chunkLen;
    }

    if(!saltLen || saltLen<this.minLength) {
        this.saltLen = this.minLength;
    } else {
        this.saltLen = saltLen;
    }
};

KleisAccount.prototype.generate = function (in1, in2) {
    var strPart1 = in1.removeAccents().replace(/[^A-Z|^0-9]/gi, '').toLowerCase();
    var strPart2 = in2.removeAccents().replace(/[^A-Z|^0-9]/gi, '').toLowerCase();
    var strA = strPart1.substr(0, this.chunkLen);
    var strB = strPart2.substr(0, this.chunkLen);
    if (strA.length < this.chunkLen) {
        var len = this.chunkLen + (this.chunkLen - strA.length);
        if (strPart2.length >= len) {
            strB = strPart2.substr(0, len);
        }
    }
    if (strB.length < this.chunkLen) {
        var len = this.chunkLen + (this.chunkLen - strB.length);
        if (strPart1.length >= len){
            strA = strPart1.substr(0, len);
        }
    }
    var len = this.saltLen + (this.chunkLen - strA.length) + (this.chunkLen - strB.length);
    var randomSalt = new RandomPassword();
    var accountSalt = randomSalt.create(len, randomSalt.chrNumbers);
    return strA + strB + accountSalt;
};

/*** Kleis Password Generator ***/

var KleisPassword = function (length) {
	this.minLength = 8;

    if(!length || length<this.minLength) {
        this.length = this.minLength;
    } else {
        this.length = chunkLen;
    }
};

KleisPassword.prototype.generate = function () {
    var randomPassword = new RandomPassword();
    var charset = randomPassword.chrLower+randomPassword.chrNumbers;
    return randomPassword.create(this.length, charset);
}

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
	let _length=this.adjustLengthWithinLimits(length);
	let _characters=this.secureCharacterCombination(characters);

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
	let defaultCharacters=this.chrLower+this.chrUpper+this.chrNumbers;

	if(!characters || this.trim(characters)=="")
		return defaultCharacters;
	else if(!this.containsAtLeast(characters, [this.chrLower, this.chrUpper, this.chrNumbers, this.chrSymbols]))
		return defaultCharacters;
	else
		return characters;

};

// Private: Assemble password using a string of characters the password will consist of.
RandomPassword.prototype.assemblePassword = function(characters, length) {
	let randMax=this.chrNumbers.length;
	let randMin=randMax-4;
	let index=this.random(0, characters.length-1);
	let password="";

	for(let i=0; i<length; i++) {
		let jump=this.random(randMin, randMax);
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
	for(let i=0; i<strings.length; i++) {
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

String.prototype.removeAccents = function() {

    var removalMap = {
        'A'  : /[AⒶＡÀÁÂẦẤẪẨÃĀĂẰẮẴẲȦǠÄǞẢÅǺǍȀȂẠẬẶḀĄ]/g,
        'AA' : /[Ꜳ]/g,
        'AE' : /[ÆǼǢ]/g,
        'AO' : /[Ꜵ]/g,
        'AU' : /[Ꜷ]/g,
        'AV' : /[ꜸꜺ]/g,
        'AY' : /[Ꜽ]/g,
        'B'  : /[BⒷＢḂḄḆɃƂƁ]/g,
        'C'  : /[CⒸＣĆĈĊČÇḈƇȻꜾ]/g,
        'D'  : /[DⒹＤḊĎḌḐḒḎĐƋƊƉꝹ]/g,
        'DZ' : /[ǱǄ]/g,
        'Dz' : /[ǲǅ]/g,
        'E'  : /[EⒺＥÈÉÊỀẾỄỂẼĒḔḖĔĖËẺĚȄȆẸỆȨḜĘḘḚƐƎ]/g,
        'F'  : /[FⒻＦḞƑꝻ]/g,
        'G'  : /[GⒼＧǴĜḠĞĠǦĢǤƓꞠꝽꝾ]/g,
        'H'  : /[HⒽＨĤḢḦȞḤḨḪĦⱧⱵꞍ]/g,
        'I'  : /[IⒾＩÌÍÎĨĪĬİÏḮỈǏȈȊỊĮḬƗ]/g,
        'J'  : /[JⒿＪĴɈ]/g,
        'K'  : /[KⓀＫḰǨḲĶḴƘⱩꝀꝂꝄꞢ]/g,
        'L'  : /[LⓁＬĿĹĽḶḸĻḼḺŁȽⱢⱠꝈꝆꞀ]/g,
        'LJ' : /[Ǉ]/g,
        'Lj' : /[ǈ]/g,
        'M'  : /[MⓂＭḾṀṂⱮƜ]/g,
        'N'  : /[NⓃＮǸŃÑṄŇṆŅṊṈȠƝꞐꞤ]/g,
        'NJ' : /[Ǌ]/g,
        'Nj' : /[ǋ]/g,
        'O'  : /[OⓄＯÒÓÔỒỐỖỔÕṌȬṎŌṐṒŎȮȰÖȪỎŐǑȌȎƠỜỚỠỞỢỌỘǪǬØǾƆƟꝊꝌ]/g,
        'OI' : /[Ƣ]/g,
        'OO' : /[Ꝏ]/g,
        'OU' : /[Ȣ]/g,
        'P'  : /[PⓅＰṔṖƤⱣꝐꝒꝔ]/g,
        'Q'  : /[QⓆＱꝖꝘɊ]/g,
        'R'  : /[RⓇＲŔṘŘȐȒṚṜŖṞɌⱤꝚꞦꞂ]/g,
        'S'  : /[SⓈＳẞŚṤŜṠŠṦṢṨȘŞⱾꞨꞄ]/g,
        'T'  : /[TⓉＴṪŤṬȚŢṰṮŦƬƮȾꞆ]/g,
        'TZ' : /[Ꜩ]/g,
        'U'  : /[UⓊＵÙÚÛŨṸŪṺŬÜǛǗǕǙỦŮŰǓȔȖƯỪỨỮỬỰỤṲŲṶṴɄ]/g,
        'V'  : /[VⓋＶṼṾƲꝞɅ]/g,
        'VY' : /[Ꝡ]/g,
        'W'  : /[WⓌＷẀẂŴẆẄẈⱲ]/g,
        'X'  : /[XⓍＸẊẌ]/g,
        'Y'  : /[YⓎＹỲÝŶỸȲẎŸỶỴƳɎỾ]/g,
        'Z'  : /[ZⓏＺŹẐŻŽẒẔƵȤⱿⱫꝢ]/g,
        'a'  : /[aⓐａẚàáâầấẫẩãāăằắẵẳȧǡäǟảåǻǎȁȃạậặḁąⱥɐ]/g,
        'aa' : /[ꜳ]/g,
        'ae' : /[æǽǣ]/g,
        'ao' : /[ꜵ]/g,
        'au' : /[ꜷ]/g,
        'av' : /[ꜹꜻ]/g,
        'ay' : /[ꜽ]/g,
        'b'  : /[bⓑｂḃḅḇƀƃɓ]/g,
        'c'  : /[cⓒｃćĉċčçḉƈȼꜿↄ]/g,
        'd'  : /[dⓓｄḋďḍḑḓḏđƌɖɗꝺ]/g,
        'dz' : /[ǳǆ]/g,
        'e'  : /[eⓔｅèéêềếễểẽēḕḗĕėëẻěȅȇẹệȩḝęḙḛɇɛǝ]/g,
        'f'  : /[fⓕｆḟƒꝼ]/g,
        'g'  : /[gⓖｇǵĝḡğġǧģǥɠꞡᵹꝿ]/g,
        'h'  : /[hⓗｈĥḣḧȟḥḩḫẖħⱨⱶɥ]/g,
        'hv' : /[ƕ]/g,
        'i'  : /[iⓘｉìíîĩīĭïḯỉǐȉȋịįḭɨı]/g,
        'j'  : /[jⓙｊĵǰɉ]/g,
        'k'  : /[kⓚｋḱǩḳķḵƙⱪꝁꝃꝅꞣ]/g,
        'l'  : /[lⓛｌŀĺľḷḹļḽḻſłƚɫⱡꝉꞁꝇ]/g,
        'lj' : /[ǉ]/g,
        'm'  : /[mⓜｍḿṁṃɱɯ]/g,
        'n'  : /[nⓝｎǹńñṅňṇņṋṉƞɲŉꞑꞥ]/g,
        'nj' : /[ǌ]/g,
        'o'  : /[oⓞｏòóôồốỗổõṍȭṏōṑṓŏȯȱöȫỏőǒȍȏơờớỡởợọộǫǭøǿɔꝋꝍɵ]/g,
        'oi' : /[ƣ]/g,
        'ou' : /[ȣ]/g,
        'oo' : /[ꝏ]/g,
        'p'  : /[pⓟｐṕṗƥᵽꝑꝓꝕ]/g,
        'q'  : /[qⓠｑɋꝗꝙ]/g,
        'r'  : /[rⓡｒŕṙřȑȓṛṝŗṟɍɽꝛꞧꞃ]/g,
        's'  : /[sⓢｓßśṥŝṡšṧṣṩșşȿꞩꞅẛ]/g,
        't'  : /[tⓣｔṫẗťṭțţṱṯŧƭʈⱦꞇ]/g,
        'tz' : /[ꜩ]/g,
        'u'  : /[uⓤｕùúûũṹūṻŭüǜǘǖǚủůűǔȕȗưừứữửựụṳųṷṵʉ]/g,
        'v'  : /[vⓥｖṽṿʋꝟʌ]/g,
        'vy' : /[ꝡ]/g,
        'w'  : /[wⓦｗẁẃŵẇẅẘẉⱳ]/g,
        'x'  : /[xⓧｘẋẍ]/g,
        'y'  : /[yⓨｙỳýŷỹȳẏÿỷẙỵƴɏỿ]/g,
        'z'  : /[zⓩｚźẑżžẓẕƶȥɀⱬꝣ]/g,
    };

    var str = this;

    for(var latin in removalMap) {
      var nonLatin = removalMap[latin];
      str = str.replace(nonLatin , latin);
    }

    return str;
}

//# sourceMappingURL=app.js.map
