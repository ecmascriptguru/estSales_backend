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

// let env = "dev";
// let env = "staging";
let env = "production";
let apiBaseUrl = null;
if (env === "dev") {
    apiBaseUrl = "http://localhost:8000/api/v1/";
} else if(env === "staging") {
    apiBaseUrl = "http://54.210.141.168/api/v1/";
} else {
    apiBaseUrl = "http://34.230.77.124/api/v1/";
}

let Calculator = (function() {
    let _domain = domains[0],
        _bsr = 1,
        _category = "eBooks",
        _data = [],
        _initialSamplesAPIBaseUrl = apiBaseUrl + "get_initial_samples"
        _estimation = 0,
        $_domain = $("#domain"),
        $_category = $("#category"),
        $_bsr = $("#bsr"),
        $add_sample = $("#add_sample"),
        $newForm = $("#new-panel"),
        $demo = $("#demo-panel"),
        token = $("meta[name='csrf-token']")[0].content,
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

    let getSamples = (domain, category, success, failure) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: _initialSamplesAPIBaseUrl,
            method: "post",
            data: {
                domain: domain,
                category: category
            },
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
        getSamples(_domain, _category, function(samples) {
            _data = samples;
            $_domain.change((event) => {
                _domain = event.target.value;
                getSamples(_domain, _category, (response) => {
                    _data = response;
                    calculate();
                });
            });

            $_bsr.change((event) => {
                _bsr = parseInt(event.target.value);
                calculate();
            });

            $_category.change((event) => {
                _category = event.target.value;
                getSamples(_domain, _category, (response) => {
                    _data = response;
                    calculate();
                });
            });

            $add_sample.click(() => {
                $demo.hide();
                $newForm.show();
            });

            calculate();
        })
    }

    return {
        init: init
    }
})();

let SampleForm = (function() {
    let _domain = null,
        _bsr = null,
        _sales = null,
        _category = 2,
        $newForm = $("#new-panel"),
        $demo = $("#demo-panel"),
        $btnBack = $("#back"),
        $btnSave = $("#save"),
        addSampleApiUrl = apiBaseUrl + 'samples/add',
        $domain = $("#new_domain"),
        $bsr = $("#new_bsr"),
        $category = $("#new_category"),
        token = $("meta[name='csrf-token']").attr('content'),
        $sales = $("#sales");

    let saveSample = (param, callback) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: addSampleApiUrl,
            method: "post",
            data: param,
            success: (response) => {
                if (response.status) {
                    if (typeof callback == "function") {
                        callback(response);
                    }
                }
            }
        })
    };

    let initEvents = () => {

        $btnBack.click(() => {
            $newForm.hide();
            $demo.show();
        });

        $btnSave.click(() => {
            saveSample({
                domain: _domain,
                category: _category,
                bsr: _bsr,
                sales: _sales
            }, (response) => {
                console.log(response);
            });
        });

        $domain.change((event) => {
            _domain = event.target.value;
        });

        $category.change((event) => {
            _category = event.target.value;
        })

        $bsr.change((event) => {
            _bsr = event.target.value;
        });

        $sales.change((event) => {
            _sales = event.target.value;
        });
    };
    
    let init = () => {
        _domain = $domain.val();
        _bsr = parseInt($bsr.val());
        _sales = parseInt($sales.val());
        _category = parseInt($category.val());

        initEvents();
    };

    return {
        init: init
    };
})();

(function() {
    Calculator.init();
    SampleForm.init();
})();