import { Component, OnInit } from '@angular/core';
import { ViewChild } from '@angular/core';
import { ProfileService } from "../services/profile.service";
import {Router} from "@angular/router";
import { ProfileEmailModel} from "../models/profile.model";
import {DialogBoxComponent} from "../../dialogBox/dialogBox.component";

import { UserInfoService } from "../../services/user-info.service";
import {AlertService} from "../../services/alert.service";

@Component({
  selector: 'app-profile-email',
  templateUrl: './profileEmail.component.html',
  styleUrls: ['./profileEmail.component.scss'],
 // providers: [ProfileService]
})
export class ProfileEmailComponent implements OnInit {

  profileEmail: ProfileEmailModel[] = []; // array object for get call

  addedEmail: ProfileEmailModel = <ProfileEmailModel>{}; // Single object for post call

  @ViewChild(DialogBoxComponent) dialogBox: DialogBoxComponent;

  constructor(private z: ProfileService, private router: Router, private y: UserInfoService,
              private x: AlertService) {
  }

  ngOnInit() {
    this.getEmail();
  }

  getEmail() {
    this.z.getProfileEmail().subscribe((result) => {
      this.profileEmail = result.details;
    })
  }

  openAddNewEmail() {
    this.addedEmail = <ProfileEmailModel>{};
    this.dialogBox.openDialogBox();
  }

  submit() {
    this.z.addEmail(this.addedEmail).subscribe((result) => {
        this.dialogBox.closeDialogBox();
        this.x.success("Email added successfully.");
        this.getEmail();
    });
  }

  deleteEmail(toBeDeletedEmail:ProfileEmailModel){

    // Delete Identifier will only work in case it is not the logged in Identifier

    if(toBeDeletedEmail.identifier != this.y.getIdentifier()) {
      this.z.deletedEmail(toBeDeletedEmail).subscribe((result) => {
        this.x.success("Email deleted successfully.");
        this.getEmail();
      });
    } else {
      this.x.error("Email cannot be deleted! User currently logged in with this email.");
    }
  }
}
