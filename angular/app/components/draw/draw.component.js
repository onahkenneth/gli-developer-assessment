class DrawController{
    constructor(API, ToastService, $localStorage, $http){
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;
        this._localStorage = $localStorage;
        this.$http = $http;
    }

    $onInit(){
        delete this._localStorage.draw;
    }

    fetchDraw() {
        this.API.one('draw').get().then((response) => {
            this.draw = response.plain();

            this.storeDraw(this.draw.data)

        }, (response) => {
            this.failed(response);
        });
    }

    getDraw()
    {
        return this._localStorage.draw;
    }

    storeDraw(data)
    {
        let draw = this._localStorage.draw || [];

        if(draw.length >= 10) {
            draw.shift();
        }

        draw.push(data);

        this._localStorage.draw = draw;
    }

    downloadCsv()
    {
        this.$http({method: 'GET', url: '/api/download'}).
        then((response) => {

            let anchor = angular.element('<a/>');
            anchor.attr({
                href: 'data:attachment/csv;charset=utf-8,' + encodeURI(response.data),
                target: '_blank',
                download: 'lotto-draw.csv'
            })[0].click();

            anchor.remove();
        }, (response) => {
            this.failed(response);
        });
    }

    failed(response) {
        if (response.status === 422) {
            for (let error in response.data.errors) {
                return this.ToastService.error(response.data.errors[error][0]);
            }
        }
        this.ToastService.error(response.statusText);
    }
}

export const DrawComponent = {
    templateUrl: './views/app/components/draw/draw.component.html',
    controller: DrawController,
    controllerAs: 'vm',
    bindings: {}
};
