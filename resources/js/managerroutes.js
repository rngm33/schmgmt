// dashboard
import Dashboard from './components/Manager/Home.vue'
//luckydraw
import LuckyDraw from './components/Manager/luckydraw/List.vue'
import LuckyDrawNew from './components/Manager/luckydraw/New.vue'
import LuckyDrawEdit from './components/Manager/luckydraw/Edit.vue'
//kista
import Kista from './components/Manager/kista/List.vue'
import KistaNew from './components/Manager/kista/New.vue'
import KistaEdit from './components/Manager/kista/Edit.vue'

import K_HasOpening from './components/Manager/kistahasopening/List.vue'


//agent
import Agent from './components/Manager/agent/List.vue'
import AgentNew from './components/Manager/agent/New.vue'
import AgentEdit from './components/Manager/agent/Edit.vue'

//agenthaspaid
import A_HasPaid from './components/Manager/agenthaspaid/List.vue'

//commission
import Commision from './components/Manager/agenthascommision/List.vue'

//bank balance
import BankBalance from './components/Manager/bankbalance/List.vue'
import BankBalanceNew from './components/Manager/bankbalance/New.vue'
import BankBalanceEdit from './components/Manager/bankbalance/Edit.vue'
import BankBalanceWalletTransfer from './components/Manager/cashbalance/WalletTransfer.vue'
import BankBalanceBankTransfer from './components/Manager/cashbalance/BankTransfer.vue'
import BankBalanceCashTransfer from './components/Manager/digitalbalance/CashTransfer.vue'

//cash balance
import CashBalance from './components/Manager/cashbalance/List.vue'
import CashBalanceEdit from './components/Manager/cashbalance/Edit.vue'
import CashBalanceWalletTransfer from './components/Manager/cashbalance/WalletTransfer.vue'
import CashBalanceBankTransfer from './components/Manager/cashbalance/BankTransfer.vue'

//digital balance
import DigitalBalance from './components/Manager/digitalbalance/List.vue'
import DigitalBalanceNew from './components/Manager/digitalbalance/New.vue'
import DigitalBalanceEdit from './components/Manager/digitalbalance/Edit.vue'
import DigitalBalanceCashTransfer from './components/Manager/digitalbalance/CashTransfer.vue'
import DigitalBalanceBankTransfer from './components/Manager/digitalbalance/BankTransfer.vue'


//subagent
import SubAgent from './components/Manager/subagent/List.vue'
import SubAgentNew from './components/Manager/subagent/New.vue'
import SubAgentEdit from './components/Manager/subagent/Edit.vue'



import Client from './components/Manager/client/List.vue'
import ClientNew from './components/Manager/client/New.vue'
import ClientEdit from './components/Manager/client/Edit.vue'

//detail
import Detail from './components/Manager/detail/List.vue'
import LotteryPrize from './components/Manager/lotteryprize/New.vue'
import LotteryPrizeList from './components/Manager/lotteryprize/List.vue'

//remaining
import Remaining from './components/Manager/remaining/List.vue'
//client list
import ClientList from './components/Manager/clientlist/List.vue'
//Expense
import Expense from './components/Manager/expense/List.vue'
import ExpenseNew from './components/Manager/expense/New.vue'
import ExpenseEdit from './components/Manager/expense/Edit.vue'
import ExpenseList from './components/Manager/expense/ExpenseList.vue'

import Purchase from './components/Manager/purchase/List.vue'
import PurchaseNew from './components/Manager/purchase/New.vue'
import PurchaseEdit from './components/Manager/purchase/Edit.vue'
import Sale from './components/Manager/sale/List.vue'

import Supplier from './components/Manager/supplier/List.vue'
import SupplierNew from './components/Manager/supplier/New.vue'

import IncomeExpenditure from './components/Manager/incomeexpenditure/Detail.vue'
import IncomeExpenditureList from './components/Manager/incomeexpenditure/List.vue'
import IncomeExpenditureNew from './components/Manager/incomeexpenditure/New.vue'
import IncomeExpenditureEdit from './components/Manager/incomeexpenditure/Edit.vue'

import AssetsLiabilities from './components/Manager/assetsliabilities/Detail.vue'
import AssetsLiabilitiesList from './components/Manager/assetsliabilities/List.vue'
import AssetsLiabilitiesNew from './components/Manager/assetsliabilities/New.vue'
import AssetsLiabilitiesEdit from './components/Manager/assetsliabilities/Edit.vue'

import Booking from './components/Manager/booking/List.vue'
import BookingNew from './components/Manager/booking/New.vue'
import BookingEdit from './components/Manager/booking/Edit.vue'

import Voucher from './components/Manager/voucher/List.vue'
import VoucherAgent from './components/Manager/voucher/AgentList.vue'

import Record from './components/Manager/record/List.vue'
import RecordNew from './components/Manager/record/New.vue'
import RecordEdit from './components/Manager/record/Edit.vue'

import Payment from './components/Manager/payment/List.vue'
	
// report
import Report from './components/Manager/report/List.vue'

import TpnpReport from './components/Manager/report/tpnp/List.vue'
import TpnplReport from './components/Manager/report/tpnpl/List.vue'
import AgentReport from './components/Manager/report/agent/List.vue'
import ExpenseReport from './components/Manager/report/expense/List.vue'
import LotteryPrizeReport from './components/Manager/report/lotteryprize/List.vue'
import PurchaseReport from './components/Manager/report/purchase/List.vue'
import IncomeExpenditureReport from './components/Manager/report/incomeexpenditure/List.vue'
import AssetsLiabilitiesReport from './components/Manager/report/assetsliabilities/List.vue'
import ExpenditureReport from './components/Manager/report/expenditure/List.vue'
import RecordReport from './components/Manager/report/record/List.vue'
import PreviewReport from './components/Manager/report/preview/List.vue'
import MemberReport from './components/Manager/report/member/List.vue'

import VoucherReport from './components/Manager/report/voucher/List.vue'
import VoucherPrint from './components/Manager/report/voucher/PrintReceipt.vue'
import PaymentMethod from './components/Manager/report/paymentmethod/List.vue'

//password change
import ChangePassword from './components/Manager/Password.vue'


export const routes = [
	// dashboard
	{
		path:'/',
		name: 'dashboard',
		component:Dashboard
	},
	{
		path:'/luckydraw',
		name: 'luckydraw',
		component:LuckyDraw
	},
	{
		path:'/luckydraw/create',
		component:LuckyDrawNew
	},
	{
		path:'/luckydraw/:luckydrawid/edit',
		component: LuckyDrawEdit
	},
	{
		path:'/kista',
		name: 'kista',
		component:Kista
	},
	{
		path:'/kista/create',
		component:KistaNew
	},
	{
		path:'/kista/:kistaid/edit',
		component: KistaEdit
	},
	{
		path:'/kistahasopening',
		name: 'kistahasopening',
		component:K_HasOpening
	},
	{
		path:'/agent/add/client/:agentid',
		component:Client
	},
	{
		path:'/client/:agentid/create',
		component:ClientNew
	},
	{
		path:'/client/:clientid/edit',
		component:ClientEdit
	},
	{
		path:'/agent',
		component: Agent
	},
	{
		path:'/agent/create',
		component:AgentNew
	},
	{
		path:'/agent/:agentid/edit',
		component: AgentEdit
	},
	{
		path:'/agent/commision/:agentid',
		component: Commision

	},
	//subagent
	{
		path:'/agent/add/subagent/:agentid',
		component:SubAgent
	},
	{
		path:'/subagent/:agentid/create',
		component:SubAgentNew
	},
	{
		path:'/subagent/:agentid/edit',
		component:SubAgentEdit
	},
	{
		path:'/detail',
		component: Detail
	},
	{
		path:'/client/prize/:detailid',
		component:LotteryPrize
	},
	{
		path:'/lotteryprize',
		component:LotteryPrizeList
	},

	//ramaining money
	{
		path:'/remaining',
		component: Remaining
	},	

	{
		path:'/clientlist',
		component: ClientList
	},

	//expense
	{
		path:'/kista/has/expense/:kistaid/:luckydrawid',
		component: Expense
	},	
	{
		path:'/expense/:kistaid/:luckydrawid/create',
		component:ExpenseNew
	},
	{
		path:'/expense/:expenseid/edit',
		component:ExpenseEdit
	},
	{
		path:'/expenselist',
		component:ExpenseList
	},
	{
		path:'/purchase',
		component:Purchase
	},
	{
		path:'/purchase/create',
		component: PurchaseNew
	},
	{
		path:'/purchase/:purchaseid/edit',
		component: PurchaseEdit
	},
	{
		path:'/sale',
		component:Sale
	},
	{
		path:'/supplier',
		component:Supplier
	},
	{
		path:'/supplier/create',
		component: SupplierNew
	},
	{
		path:'/incomeexpenditure',
		component: IncomeExpenditure
	},
	{
		path:'/incomeexpenditurelist',
		component: IncomeExpenditureList
	},
	{
		path:'/incomeexpenditure/:incomeexpenditureid/create',
		component: IncomeExpenditureNew
	},
	{
		path:'/incomeexpenditure/:incomeexpenditureid/edit',
		component: IncomeExpenditureEdit
	},
	{
		path:'/assetsliabilities',
		component: AssetsLiabilities
	},
	{
		path:'/assetsliabilitieslist',
		component: AssetsLiabilitiesList
	},
	{
		path:'/assetsliabilities/:assetsliabilitiesid/create',
		component: AssetsLiabilitiesNew
	},
	{
		path:'/assetsliabilities/:assetsliabilitiesid/edit',
		component: AssetsLiabilitiesEdit
	},
	{
		path:'/bankbalance',
		component: BankBalance
	},
	{
		path:'/bankbalance/create',
		component: BankBalanceNew
	},
	{
		path:'/bankbalance/:bankbalanceid/edit',
		component: BankBalanceEdit
	},
	{
		path:'/bankbalance/:bankbalanceid/banktransfer',
		component: BankBalanceBankTransfer
	},
	{
		path:'/bankbalance/:bankbalanceid/wallettransfer',
		component: BankBalanceWalletTransfer
	},
	{
		path:'/bankbalance/:bankbalanceid/cashtransfer',
		component: BankBalanceCashTransfer
	},

	{
		path:'/cashbalance',
		component: CashBalance
	},
	{
		path:'/cashbalance/:cashbalanceid/edit',
		component: CashBalanceEdit
	},
	{
		path:'/cashbalance/:cashbalanceid/banktransfer',
		component: CashBalanceBankTransfer
	},
	{
		path:'/cashbalance/:cashbalanceid/wallettransfer',
		component: CashBalanceWalletTransfer
	},

	{
		path:'/digitalbalance',
		component: DigitalBalance
	},
	{
		path:'/digitalbalance/create',
		component: DigitalBalanceNew
	},
	{
		path:'/digitalbalance/:digitalbalanceid/edit',
		component: DigitalBalanceEdit
	},
	{
		path:'/digitalbalance/:digitalbalanceid/banktransfer',
		component: DigitalBalanceBankTransfer
	},
	{
		path:'/digitalbalance/:digitalbalanceid/cashtransfer',
		component: DigitalBalanceCashTransfer
	},
	{
		path:'/agenthaspaid',
		component: A_HasPaid
	},
	{
		path:'/booking',
		component: Booking
	},
	{
		path:'/booking/create',
		component: BookingNew
	},
	{
		path:'/booking/:bookingid/edit',
		component: BookingEdit
	},
	{
		path:'/voucher',
		component: Voucher
	},
	{
		path:'/voucher/agent/:agentid',
		component: VoucherAgent,
		name: 'voucheragent',
		props: true,
		
	},
	//record
	{
		path:'/record',
		component: Record
	},
	{
		path:'/record/create',
		component: RecordNew
	},
	{
		path:'/record/:recordid/edit',
		component: RecordEdit
	},

	//payment
	{
		path:'/payment',
		component: Payment
	},

	//report
	{
		path:'/report',
		name: 'report',
		component:Report
	},
	{
		path:'/report/tpnp',
		component: TpnpReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/tpnpl',
		component: TpnplReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/agent',
		component: AgentReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/expense',
		component: ExpenseReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/lotteryprize',
		component: LotteryPrizeReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/purchase',
		component: PurchaseReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/incomeexpenditure',
		component: IncomeExpenditureReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/assetsliabilities',
		component: AssetsLiabilitiesReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/expenditure',
		component: ExpenditureReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/record',
		component: RecordReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/preview',
		component: PreviewReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/member',
		component: MemberReport,
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/voucher',
		component: VoucherReport,
		name:'voucherreport',
		meta: { bodyClass: 'sidebar-collapse',
		keepAlive: true },
	},
	{
		path:'/report/voucher/print:type',
		component: VoucherPrint,
		name:'voucherprint',
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/report/paymentmethod',
		component: PaymentMethod,
		name:'paymentmethod',
		meta: { bodyClass: 'sidebar-collapse' },
	},
	{
		path:'/changepassword',
		component: ChangePassword
	},


]