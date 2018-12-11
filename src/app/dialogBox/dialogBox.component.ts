import {Component, Input, OnInit, TemplateRef, ViewChild} from '@angular/core';
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';

@Component({
  selector: 'dialog-box',
  templateUrl: './dialogBox.component.html'
})
export class DialogBoxComponent implements OnInit {

  @ViewChild('dialogBoxTemplate') dialogBoxTemplate: TemplateRef<any>;

  modalRef: BsModalRef;

  constructor(private modalService: BsModalService) {}

  openModal(template: TemplateRef<any>, size: string) {
    this.modalRef = this.modalService.show(template, {
      backdrop : 'static',
      keyboard : false,
      class: `modal-${size}`
    }); }

  closeModal() {
    this.modalRef.hide();  // Main Modal (dialog box )closed
  }

  ngOnInit() {}

  openDialogBox() {
    this.openModal(this.dialogBoxTemplate, 'lg');
  }

  closeDialogBox() {
    //console.log('Modal closed');
    this.closeModal();
  }
}
