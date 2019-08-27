import $ from 'jquery';

/**
 * Class Text
 */
export default class Text {

    /**
     * Text constructor
     */
    constructor(number, text) {
        this.h6     = $('h6');
        this.number = number;
        this.text   = text;

        this.events();
    }

    /**
     * return void
     */
    events() {
        this.h6.off().on('click', this.output.bind(this));
    }

    /**
     * return void
     */
    output() {
    }
}
