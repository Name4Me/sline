    TTovar = {
	    _GID: '',
	    _tip: '',
	    _rozmir: '',
	    _rist: '',
	    sanaliz: function (inStr) {
			this._GID = '';
	    	this._tip = '';
	    	this._rozmir = '';
	    	this._rist = '';

	        var ipos = -1;
	        if (inStr.indexOf('*')!=-1) ipos = inStr.indexOf('*');
	        if (inStr.indexOf('!')!=-1) ipos = inStr.indexOf('!');
            //alert (ipos);
			for (i=0; i < inStr.length; i++) {
				//alert(inStr.charAt(i));
				switch (inStr.charAt(i)){
					case '0':
					case '1':
					case '2':
					case '3':
					case '4':
					case '5':
					case '6':
					case '7':
					case '8':
					case '9':
					        if (i<=1) {this._GID = this._GID + inStr.charAt(i);}
					        	else {if ((ipos<i) && (this._rozmir.length <= 3))
					     				{this._rozmir = this._rozmir + inStr.charAt(i);}
					     					else {this._tip = this._tip + inStr.charAt(i);}
					     		};

					break;
					case ' ': if  (this._tip.length > 0) this._tip = this._tip + inStr.charAt(i);
					case '!':
					case '*': break;
					default:  this._tip = this._tip + inStr.charAt(i);
				}
			}

			if ((this._rozmir.length == 3) && (this._rozmir.charAt(0) !='1')) {
				this._rist = this._rozmir.charAt(2);
				this._rozmir = this._rozmir.substr(0,2);
			}

	    }
    }