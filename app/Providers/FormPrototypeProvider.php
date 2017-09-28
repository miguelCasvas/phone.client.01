<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;
use Html;
use Response;

class FormPrototypeProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->componentForm();
    }

    /**
     * Components Form
    */
    private function componentForm(){

        ///**
        // * Campo tipo file
        // * @param nameLabel => nombre del label
        // * @param nameCamp  => nombre del campo
        // * @param array($attributes) => atributos adicionales []
        // */
        //Form::component('bsFile','0_components.form.file',['nameLabel','nameCamp','attributes' => [], 'transArgs' => []]);
        //
        ///**
        // * Campo tipo Fecha
        // */
        //Form::component('bsDate','0_components.form.date',['nameLabel','nameCamp','value' => null,'attributes' => []]);
        //
        // /**
        // * Campo tipo Check
        // */
        //Form::component('bsCheckbox','0_components.form.checkbox',['nameLabel','nameCamp','value'=> null,'attributes' => []]);
        //
        ///**
        // * Campo tipo password
        // */
        //Form::component('bsPassword','0_components.form.password',['nameLabel','nameCamp','attributes' => []]);
        //
        ///**
        // * Campo tipo textarea
        // */
        //Form::component('bsTextarea','0_components.form.textarea',['name','nameCamp','value' => null,'attributes' => [], 'transArgs' => []]);
        //
        ///**
        // * Campo tipo hidden
        // */
        //Form::component('bsHidden','0_components.form.hidden',['nameCamp','value' => null,'attributes' => []]);
        //
        ///**
        // * Button
        // */
        //Form::component('bsButton','0_components.form.button',['name','attributes' => []]);
        //
        ///**
        // * Submit
        // */
        //Form::component('bsSubmit','0_components.form.submit',['name','attributes' => []]);
        //
        ///**
        // * Campo tipo Label
        // */
        //Form::component('bsLabel','0_components.form.label',['name','attributes' => []]);
        //
        ///**
        // * Campo tipo radio
        // */
        //Form::component('bsRadio','0_components.form.radio',['nameLabel','nameCamp','value' => null,'attributes' => []]);
        //
        ///**
        // * Campo tipo email
        // */
        //Form::component('bsEmail','0_components.form.email',['nameLabel','nameCamp','value' => null,'attributes' => [], 'transArgs' => []]);
        //
        ///**
        // * Campo tipo number
        // */
        //Form::component('bsNumber'  ,'0_components.form.number',  ['nameLabel','nameCamp','value' => null,'attributes' => [], 'transArgs' => []]);

        /**
         * Campo tipo text
         *
         */
        Form::component('bsText', '0_components.form.text',  ['titulo', 'nombCamp', 'value' => null, 'attributes' => [], 'obligatorio' => false]);

        ///**
        // * Campo tipo select
        // */
        //Form::component('bsSelect'  ,'0_components.form.select',  ['nameLabel','nameCamp','value' => [],'selected','attributes' => [], 'transArgs' => []]);
        //
        ///**
        // * Campo Data List
        // */
        //Form::component('bsDataList'  ,'0_components.form.dataList',  ['nameLabel','nameCamp','value' => [],'selected','attributes' => []]);
        //
        ///**
        // * Campo tipo text con boton
        // */
        //Form::component('bsTextButton', '0_components.form.textButton', ['nameLabel','nameCamp','value' => null,'attributes' => []]);
        //
        ///**
        // * Campos con icon
        // */
        //Form::component('bsTextIcon', '0_components.form.textIcon', ['nameLabel','nameCamp','iconVal','value' => null,'attributes' => []]);
        //Form::component('bsNumberIcon', '0_components.form.numberIcon', ['nameLabel','nameCamp','iconVal','value' => null,'attributes' => [], 'transArgs' => []]);
        //
        //
        ///**
        // * Campo tipo button con icon
        // */
        //Form::component('bsButtonIcon','0_components.form.buttonIcon',['icon','attributes' => []]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
