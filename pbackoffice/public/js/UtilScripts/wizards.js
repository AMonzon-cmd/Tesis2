class Steps{
  constructor(wizard){
    this.wizard = wizard;
    this.steps = this.getSteps();
    this.stepsQuantity = this.getStepsQuantity();
    this.currentStep = 0;
  }
  
  setCurrentStep(currentStep){
    this.currentStep = currentStep;
  }
  
  getSteps(){
    return this.wizard.getElementsByClassName('step');
  }
  
  getStepsQuantity(){
    return this.getSteps().length;
  }
  
  handleConcludeStep(){
    this.steps[this.currentStep].classList.add('-completed');
  }
  
  handleStepsClasses(movement){
    if(movement > 0)
      this.steps[this.currentStep - 1].classList.add('-completed');
    else if(movement < 0)
      this.steps[this.currentStep].classList.remove('-completed');  
  }
}

class Panels{
  constructor(wizard){
    this.wizard = wizard;
    this.panelWidth = this.wizard.offsetWidth;
    this.panelsContainer = this.getPanelsContainer();
    this.panels = this.getPanels();
    this.currentStep = 0;
    
    this.updatePanelsPosition(this.currentStep);
    this.updatePanelsContainerHeight();
  }
  
  getCurrentPanelHeight(){
    return `${this.getPanels()[this.currentStep].offsetHeight}px`;
  }
  
  getPanelsContainer(){
    return this.wizard.querySelector('.panels');
  }
  
  getPanels(){
    return this.wizard.getElementsByClassName('panel');
  }
  
  updatePanelsContainerHeight(){
    this.panelsContainer.style.height = this.getCurrentPanelHeight();
  }
  
  updatePanelsPosition(currentStep){
    const panels = this.panels;
    const panelWidth = this.panelWidth;
    
    for (let i = 0; i < panels.length; i++) {
      panels[i].classList.remove(
         'movingIn',
         'movingOutBackward',
         'movingOutFoward',
         'd-none'
      );
        
      if(i !== currentStep){
        if(i < currentStep) {        
          panels[i].classList.add('movingOutBackward');       
        }
        else if( i > currentStep ){
         panels[i].classList.add('movingOutFoward');
        }
      }else{       
        panels[i].classList.add('movingIn');   
      }
    }
    
    this.updatePanelsContainerHeight();
  }
  
  setCurrentStep(currentStep){
    this.currentStep = currentStep;
    this.updatePanelsPosition(currentStep);
  }
}

class Wizard{
  constructor(obj){
    this.wizard = obj;
    this.panels = new Panels(this.wizard);
    this.steps = new Steps(this.wizard);
    this.stepsQuantity = this.steps.getStepsQuantity();
    this.currentStep = this.steps.currentStep;
    
    this.concludeControlMoveStepMethod = this.steps.handleConcludeStep.bind(this.steps);
    this.wizardConclusionMethod = this.handleWizardConclusion.bind(this);
  }
  
  updateButtonsStatus(){
    if(this.currentStep === 0)
      this.previousControl.classList.add('disabled');
    else
      this.previousControl.classList.remove('disabled');
  }
  
  updtadeCurrentStep(movement){   
    this.currentStep += movement;
    this.steps.setCurrentStep(this.currentStep);
    this.panels.setCurrentStep(this.currentStep);
    
    this.handleNextStepButton();
    this.updateButtonsStatus();
  }
  
  handleNextStepButton(){   
    if(this.currentStep === this.stepsQuantity - 1){      
      this.nextControl.innerHTML = 'Finalizar!';
      
      this.nextControl.removeEventListener('click', this.nextControlMoveStepMethod);
      this.nextControl.addEventListener('click', this.wizardConclusionMethod);
    }else{
      this.nextControl.innerHTML = 'Siguiente';
      
      this.nextControl.addEventListener('click', this.nextControlMoveStepMethod);
      this.nextControl.removeEventListener('click', this.concludeControlMoveStepMethod);
      this.nextControl.removeEventListener('click', this.wizardConclusionMethod);
    }
  }
  
  //SE COMPLETA EL ENVIO!!!
  handleWizardConclusion(){
    //CARGO LAS VARIABLES!!!
      
      //PRIMER PASO----------------------------
      var cliente = $("#cmbClientes").val();
      //----------------------------------------

      //SEGUNDO PASO---------------------------------------
      var montoEnviar = $("#txtMontoEnviar").val();
      var moneda = 1;
      if (sessionStorage.getItem("Moneda") == "USD"){
        moneda = 2;
      }
      //----------------------------------------------
      

      //TERCER PASO ---------------------------------------
      var beneficiario = $("#cmbBeneficiario").val();
      //--------------------------------------------------

      //CUARTO PASO ---------------------------------
      var metodoPago = $('input:radio[name=optMedioPago]:checked').val();
      //------------------------------------------
    
    if (this.validarFormulario(cliente, montoEnviar, moneda, beneficiario, metodoPago)){
      this.concludeControlMoveStepMethod();
      this.wizard.classList.add('completed');
          
    }
    
  };
  
  addControls(previousControl, nextControl){
    this.previousControl = previousControl;
    this.nextControl = nextControl;
    this.previousControlMoveStepMethod = this.moveStep.bind(this, -1);
    this.nextControlMoveStepMethod = this.moveStep.bind(this, 1);
    
    previousControl.addEventListener('click', this.previousControlMoveStepMethod);
    nextControl.addEventListener('click', this.nextControlMoveStepMethod);
    
    this.updateButtonsStatus();
  }
  
  moveStep(movement){
    if(this.validateMovement(movement)){
      this.updtadeCurrentStep(movement);
      this.steps.handleStepsClasses(movement);
    }else{
       throw('This was an invalid movement');
    }
  }
  
  validateMovement(movement){
    const fowardMov = movement > 0 && this.currentStep < this.stepsQuantity - 1;
    const backMov = movement < 0 && this.currentStep > 0;
    
    return fowardMov || backMov;
  }

  validarFormulario(cliente, montoEnviar, moneda, beneficiario, metodoPago){
    var formularioValido = true;
    var tituloErrores = "Error al generar transferencia"
    
    //si no hay cliente 
    if (cliente == 0){
      formularioValido = false
      alertaCaja('error', tituloErrores, 'Debe seleccionar el cliente que realiza la transferencia')
      for (var i = 0; i >= -3; i--){ 
        this.moveStep(-1);
      }
      return formularioValido
    }

    if (montoEnviar == '' || montoEnviar == ' ' || isNaN(montoEnviar) || (moneda == 1 && montoEnviar < 200) || (moneda == 2 && montoEnviar < 5)){
      formularioValido = false
      alertaCaja('error', tituloErrores, 'El monto a enviar no puede ser menor a U$S 5 o $ 200');
      for (var i = 0; i >= -2; i--){ 
        this.moveStep(-1);
      }
      return formularioValido
    }

    if (moneda != 1 && moneda != 2){
      formularioValido = false
      alertaCaja('error', tituloErrores, 'Valide la moneda o margen ingresado');
      for (var i = 0; i >= -2; i--){ 
        this.moveStep(-1);
      }
      return formularioValido;
    }

    if (beneficiario == 0){
      formularioValido = false
      alertaCaja('error', tituloErrores, 'Seleccione un beneficiario o creelo');
      for (var i = 0; i >= -1; i--){ 
        this.moveStep(-1);
      }
      return formularioValido;
    }


    if (formularioValido){
      altaTransferencia(cliente, montoEnviar, moneda, beneficiario, metodoPago);
      return formularioValido;
    }

  }
}

let wizardElement = document.getElementById('wizard');
let wizard = new Wizard(wizardElement);
let buttonNext = document.querySelector('.next');
let buttonPrevious = document.querySelector('.previous');

wizard.addControls(buttonPrevious, buttonNext);
