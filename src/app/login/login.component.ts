import { Component, OnInit } from '@angular/core';
import {UserInfo} from "../models/user-info.model";
import { UserInfoService } from '../services/user-info.service';
import {Router} from "@angular/router";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  userLoginInfo: UserInfo = <UserInfo>{};

  constructor(private a: Router, private y: UserInfoService) {
  }

  ngOnInit() {
    localStorage.removeItem('loggedInUser');
  }

  login() {
      this.y.loginService(this.userLoginInfo).subscribe((result) => {
        // Set Name in local Storage

        localStorage.setItem("loggedInUser", result.name);
        // Set SSN and identifier for use in application
        this.y.setSSN(result.ssn);  // Set SSN from Login Page Response
        this.y.setIdentifier(this.userLoginInfo.identifier); // Set Identifier of Logged In User from whatever user enters

        // Navigate to Feature Module
        this.a.navigate(['']);
    })
  }
}
