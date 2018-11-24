import { Component, OnInit } from '@angular/core';
import {UserInfo} from "../models/user-info.model";
import { UserInfoService } from '../services/user-info.service';
import {Router} from "@angular/router";

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

  userInfoLocal: UserInfo = <UserInfo>{};


  constructor(private x: Router , private z: UserInfoService) { }

  ngOnInit() {
  }

  register() {
    this.z.saveUserInfo(this.userInfoLocal).subscribe((result) => {
      // console.log(localStorage.getItem("userList"));
      console.log('Response from backend'+result);
      this.x.navigate(['/login']);
    })
  }
  }


