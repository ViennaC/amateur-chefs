function updateTotal() {
	var vol1Amt = document.getElementById("vol1Amt").value;
	var vol2Amt = document.getElementById("vol2Amt").value;
	var vol3Amt = document.getElementById("vol3Amt").value;
	var vol1Total = 0;
	var vol2Total = 0;
	var vol3Total = 0;
	if (vol1Amt != null) {
		vol1Total = vol1Amt*25;
	}
	if (vol2Amt != null) {
                vol2Total = vol2Amt*25;
        }
	if (vol3Amt != null) {
                vol3Total = vol3Amt*25;
        }
	var total = vol1Total + vol2Total + vol3Total;
	document.getElementById("orderTotal").value = "$"+total+".00";
}

function validateOrder() {
	var vol1Amt = document.getElementById("vol1Amt").value;
        var vol2Amt = document.getElementById("vol2Amt").value;
        var vol3Amt = document.getElementById("vol3Amt").value;
	if (!Number.isInteger(vol1Amt) || !Number.isInteger(vol2Amt) || !Number.isInteger(vol3Amt)) {
		alert("Quantity needs to be a whole number.");
	}
}
