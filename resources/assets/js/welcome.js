require('./bootstrap');

let domains = [
        "amazon.com",
        "amazon.ca",
        "amazon.com.au",
        "amazon.co.uk",
        "amazon.de",
        "amazon.es",
        "amazon.fr",
        "amazon.in",
        "amazon.it",
        "amazon.jp"
    ];

let env = "dev";
// let env = "staging";
let apiBaseUrl = null;
if (env === "dev") {
    apiBaseUrl = "http://localhost:8000/api/";
} else {
    apiBaseUrl = "http://example.com/api/";
}

let Calculator = (function() {
    let _domain = domains[0],
        _bsr = 1,
        _data = [],
        _initialSamplesAPIBaseUrl = apiBaseUrl + "get_initial_samples"
        _estimation = 0,
        $_domain = $("#domain"),
        $_bsr = $("#bsr"),
        apiBaseUrl = null,
        $_unit_sales = $("#estimation");

    let getEstimation = (x1, y1, x2, y2) => {
        let sqrtX1 = Math.sqrt(x1),
            sqrtX2 = Math.sqrt(x2 + 1);

        let alpa = (y2 - y1) / (sqrtX1 - sqrtX2);
        let max = (y2 * sqrtX1 - y1 * sqrtX2) / (sqrtX1 - sqrtX2);

        return {alpa, max};
    }

    let calculate = () => {

        for (let i = 0; i < _data.length; i ++) {
            if (_data[i].max < _bsr) {
                continue;
            } else {
                if (i == _data.length - 1) {
                    _estimation = _data[i].est;
                } else {
                    let coefficients = getEstimation(_data[i].min, _data[i].est, _data[i].max, _data[i + 1].est);
                    _estimation = coefficients.max - coefficients.alpa * Math.sqrt(_bsr);
                }
                break;
            }
        }
        
        $_unit_sales.val(parseInt(_estimation));
    }

    let getSamples = (domain, success, failure) => {
        $.ajax({
            url: _initialSamplesAPIBaseUrl,
            method: "post",
            data: {domain: domain},
            success: (response) => {
                if (response.status) {
                    if (typeof success === "function") {
                        success(response.samples);
                    }
                }
            },
            failure: () => {
                console.log("Failure.");
            }
        })
    }

    let init = () => {
        getSamples(_domain, function(samples) {
            _data = samples;
            $_domain.change((event) => {
                _domain = event.target.value;
                getSamples(_domain, (response) => {
                    _data = response;
                    calculate();
                });
            });

            $_bsr.change((event) => {
                _bsr = parseInt(event.target.value);
                calculate();
            });

            calculate();
        })
    }

    return {
        init: init
    }
})();

(function() {
    Calculator.init();
})();