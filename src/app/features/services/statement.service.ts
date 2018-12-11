import { HttpClient } from "@angular/common/http";

import {UserInfoService} from "../../services/user-info.service";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs";

@Injectable()

export class statementService {

  constructor(private http: HttpClient, private x: UserInfoService) {
  }

  getStatement(statement) {
    let currentSSN = this.x.getSSN();
    return <Observable<any>>this.http.get("http://localhost/dbms/getStatement?ssn="
      +currentSSN+"&sdate="+statement.startDate+"&edate="+statement.endDate);
  }
}
