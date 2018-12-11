import { Component, OnInit } from '@angular/core';
import { ViewChild } from '@angular/core';
import { ProfileService } from "../services/profile.service";
import {DialogBoxComponent} from "../../dialogBox/dialogBox.component";
import {ProfileBankModel} from "../models/profile.model";
import {AlertService} from "../../services/alert.service";


@Component({
  selector: 'app-profile-bank',
  templateUrl: './profileBank.component.html',
  styleUrls: ['./profileBank.component.scss']
})
export class ProfileBankComponent implements OnInit {

  profileBank: ProfileBankModel[] = []; // array object for get call

  addedBank: ProfileBankModel = <ProfileBankModel>{}; // Single object for post call

  @ViewChild(DialogBoxComponent) dialogBox: DialogBoxComponent;

  constructor(private z: ProfileService, private x: AlertService) { }

  ngOnInit() {
    this.getBank();
  }

  getBank() {
    this.z.getProfileBank().subscribe((result) => {
      this.profileBank = result.details;
    })
  }

  openAddNewBank() {
    this.addedBank = <ProfileBankModel>{};
    this.dialogBox.openDialogBox();
  }

  submit() {
    this.z.addBank(this.addedBank).subscribe((result) => {
      this.dialogBox.closeDialogBox();
      this.x.success("Bank Details added successfully.");
      this.getBank();
    });
  }

  deleteBank(toBeDeletedBank:ProfileBankModel){
    this.z.deletedBank(toBeDeletedBank).subscribe( (result) => {
      this.x.success("Bank details deleted successfully.");
      this.getBank();
      //this.router.navigate(['/login']);
    });
  }
}
