import { Component, OnInit, Inject } from "@angular/core";
import { Router, ActivatedRoute } from "@angular/router";
import { MAT_DIALOG_DATA, MatDialogRef, MatDialog } from "@angular/material";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { SharedataService } from "src/app/services/sharedata.service";
import { UsermanagementService } from 'src/app/services/usermanagement.service';
import { NotificationService } from 'src/app/shared/notification.service';
declare var jQuery:any;
@Component({
  templateUrl: "./dwchild.component.html",
})
export class dWcomponent implements OnInit {
  params;
  colDef;
  data;
  showActionButtons: boolean = false;
  currentroute;
  accountInfo = null;
  constructor(private router: Router, private dialog: MatDialog,private usermanage:UsermanagementService,private notifyService:NotificationService,  private sharedata: SharedataService) {
    this.currentroute = this.router.url;
    if (
      this.currentroute.includes("/admin") ||
      this.currentroute.includes("/supermaster") ||
      this.currentroute.includes("/master") ||
      this.currentroute.includes("/agent") ||
      this.currentroute.includes("/superagent") ||
      this.currentroute.includes("/clients")
    ) {
      this.showActionButtons = true;
    }
    this.usermanage.getAccountInfo().subscribe((data) => {
      if (data != null) {
        this.accountInfo = data.data;
      }
    });

  }

  agInit(params) {
    this.params = params;
    this.colDef = this.params.colDef.field;
    this.data = this.params.data;
  }
  ngOnInit() {}

  openDPDialog(): void {
    const dialogRef = this.dialog.open(dpDialog, {
      width: "500px",
      data: this.data,
    });

    dialogRef.afterClosed().subscribe((result) => {
      if (result) {
        // console.log(result)
        this.params.context.componentParent.GetuserList();
      }
    });
  }
  openDWDialog(): void {
    const dialogRef = this.dialog.open(wdDialog, {
      width: "500px",
      data: this.data,
    });

    dialogRef.afterClosed().subscribe((result) => {
      if (result) {
        this.params.context.componentParent.GetuserList();
      }
    });
  }


}

@Component({
  template: ` <h1 mat-dialog-title style="text-align: center;">
      {{ data.userName }}
    </h1>
    <hr />
    <div mat-dialog-content style="overflow: hidden;">
      <div [formGroup]="systemPointForm">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Withdraw Chips</label>
              <input
                type="number"
                onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57"
                class="form-control border-primary"
                placeholder="Chips"
                formControlName="Amount"
                min="0"
              />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" style="display: contents;">
          <div class="col-md-6">
            <div class="form-group">
            <label *ngIf="accountInfo">{{ accountInfo.userName }} Chips</label>
              <input
                type="number"
                class="form-control border-primary"
                placeholder="Chips"
                [value]="chips"
                [disabled]="true"
                min="0"
              />
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
            <label>{{ data.userName }} Chips</label>
              <input
                type="number"
                class="form-control border-primary"
                placeholder="Chips"
                [value]="amount"
                [disabled]="true"
                min="0"
              />
            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" style="display: contents;">
           <div class="col-md-6">
            <div class="form-group">
              <textarea
                id="txt_boxe"
                rows="6"
                class="form-control border-primary"
                type="text"
                *ngIf="accountInfo && data"
              >Withdraw chips from {{ data.userName }} by {{ accountInfo.userName }}: {{systemPointForm.controls.Amount.value}}</textarea>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
              <textarea
                id="txt_box"
                rows="6"
                class="form-control border-primary"
                type="text"
                *ngIf="accountInfo && data"
              >Withdraw chips by {{ accountInfo.userName }} from {{ data.userName }}</textarea>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div mat-dialog-actions align="center">
      <button mat-raised-button color="warn" (click)="onNoClick()">
        Cancel
      </button>
      <button
        mat-raised-button
        color="primary"
        (click)="transferFunds()"
        [disabled]="!systemPointForm.valid || disabled"
      >
        Update
      </button>
    </div>`,
})
export class wdDialog {
  systemPointForm: FormGroup;
  accountInfo = null;
  chips=0;
  amount=0;
  disabled:boolean=false;
  constructor(
    public dialogRef: MatDialogRef<wdDialog>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private fb: FormBuilder,
    private sharedata: SharedataService,
    private usermanage:UsermanagementService,
    private notifyService:NotificationService
  ) {
    console.log(data);
    this.amount=this.data.chips;
    this.systemPointForm = this.fb.group({
      Amount: [0, Validators.required]
    });
    this.usermanage.getAccountInfo().subscribe((data) => {
      if (data != null) {
        this.accountInfo = data.data;
        this.chips=this.accountInfo.balance;
      }
    });
    this.formControlchanged();
  }

  formControlchanged() {
    this.systemPointForm.get("Amount").valueChanges.subscribe((mode: any) => {
        if (mode > this.data.chips){
          if(this.data.chips>=0){
            this.systemPointForm.controls["Amount"].setValue(this.data.chips);
          }
      } else {
        this.chips = parseInt(this.accountInfo.balance) + mode;
        this.amount=this.data.chips-mode;
      }
    });
  }

  transferFunds(){
    if(this.systemPointForm.get("Amount").value<0){
      this.notifyService.error("Withdraw Amount can't be Negative !!");
      this.dialogRef.close();
      return false;
    }
    if(this.systemPointForm.get("Amount").value>this.data.chips){
      this.notifyService.error("Withdraw Amount can't be higher than the current !!");
      this.dialogRef.close();
      return false;
    }
    var data=  {
      amount:this.systemPointForm.get("Amount").value,
      context:"web",
      transferBy:this.data.userName,
      transferByRemarks:$("#txt_box").val(),
      transferTo:this.accountInfo.userName,
      transfertoRemarks:$("#txt_boxe").val(),
      type:1
    }
    this.disabled=true;
    this.usermanage.TransferChips(data).subscribe((data) => {
      if (data.status == "Success") {
        this.notifyService.success(data.result);
        this.dialogRef.close(data);
        this.disabled=false;
      } else {
        this.notifyService.error(data.result);
        this.disabled=false;
      }
    });
  }

  onNoClick(): void {
    this.dialogRef.close();
  }
}

@Component({
  template: `
  <h1 mat-dialog-title style="text-align: center;">
  {{ data.userName }}
</h1>
<hr />
<div mat-dialog-content style="overflow: hidden;">
  <form [formGroup]="systemPointForm">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label>Deposit Chips</label>
          <input
            type="number"
            onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57"
            class="form-control border-primary"
            placeholder="Chips"
            formControlName="Amount"
            min="0"
          />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12" style="display: contents;">
      <div class="col-md-6">
        <div class="form-group">
        <label *ngIf="accountInfo">{{ accountInfo.userName }} Chips</label>
          <input
            type="number"
            class="form-control border-primary"
            placeholder="Chips"
            [value]="chips"
            [disabled]="true"
            min="0"
          />
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
        <label>{{ data.userName }} Chips</label>
          <input
            type="number"
            class="form-control border-primary"
            placeholder="Chips"
            [value]="amount"
            [disabled]="true"
            min="0"
          />
        </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12" style="display: contents;">
       <div class="col-md-6">
        <div class="form-group">
          <textarea
            id="txt_boxe"
            rows="6"
            class="form-control border-primary"
            type="text"
            *ngIf="data && accountInfo"
          >Deposit chips to {{data.userName }} from {{ accountInfo.userName }}: {{systemPointForm.controls.Amount.value}}</textarea>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
          <textarea
            id="txt_box"
            rows="6"
            class="form-control border-primary"
            type="text"
            *ngIf="data && accountInfo"
          >Deposit chips by {{ accountInfo.userName }} to {{data.userName }}</textarea>
        </div>
        </div>
      </div>
    </div>
  </form>
</div>
<div mat-dialog-actions align="center">
  <button mat-raised-button color="warn" (click)="onNoClick()">
    Cancel
  </button>
  <button
    mat-raised-button
    color="primary"
    (click)="transferFunds()"
    [disabled]="!systemPointForm.valid || disabled"
  >
    Update
  </button>
</div>
  `,
})
export class dpDialog implements OnInit{
  systemPointForm: FormGroup;
  accountInfo = null;
  chips=0;
  amount=0;
  disabled:boolean=false;
  constructor(
    public dialogRef: MatDialogRef<dpDialog>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private fb: FormBuilder,
    private sharedata: SharedataService,
    private usermanage:UsermanagementService,
    private notifyService:NotificationService
  ) {
    console.log(data);
    this.amount=this.data.chips;
    this.systemPointForm = this.fb.group({
      Amount: [0, Validators.required],
    });
    this.usermanage.getAccountInfo().subscribe((data) => {
      if (data != null) {
        this.accountInfo = data.data;
        this.chips=this.accountInfo.balance;
      }
    });
    this.formControlchanged();
  }

  ngOnInit(){
   console.log($("#txt_boxe").val())
  } 

  formControlchanged() {
    this.systemPointForm.get("Amount").valueChanges.subscribe((mode: any) => {
      console.log(mode)
      if (mode > this.accountInfo.balance) {
        this.systemPointForm.controls["Amount"].setValue(this.accountInfo.balance);
        this.chips=0;
        this.amount=this.data.chips+this.accountInfo.balance;
      } else {
        this.chips = parseInt(this.accountInfo.balance)-mode;
        this.amount=this.data.chips+mode;
      }
    });
  }

  transferFunds(){
    var data=  {
      amount:this.systemPointForm.get("Amount").value,
      context:"web",
      transferBy:this.accountInfo.userName,
      transferByRemarks:$("#txt_boxe").val(),
      transferTo:this.data.userName,
      transfertoRemarks:$("#txt_box").val(),
      type:1
    }
    this.disabled=true;
    this.usermanage.TransferChips(data).subscribe((data) => {
      if (data.status == "Success") {
        this.notifyService.success(data.result);
        this.dialogRef.close(data);
        this.disabled=false
      } else {
        this.disabled=false
        this.notifyService.error(data.result);
      }
    });
  }

  onNoClick(): void {
    this.dialogRef.close();
  }
}
