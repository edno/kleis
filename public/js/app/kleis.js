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
