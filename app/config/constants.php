<?php
/**
 * GroupWithUs
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    groupwithus
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
 
class ConstPaymentStatus
{
    const Success = 'Success';
    const Refund = 'Refund';
    const Cancel = 'Cancel';
    const Pending = 'Pending';
}
class ConstItemStatus
{
    const Pending = 1;
    const Open = 2;
    const Canceled = 3;
    const Expired = 4;
    const Tipped = 5;
    const Closed = 6;
    const Refunded = 7;
    const PaidToMerchant = 8;
    const PendingApproval = 9;
    const Rejected = 10;
    const Draft = 11;
    const Delete = 12; //Not available in table. only for coding purpose
    const SubItem = 13; //Not available in table. only for coding purpose
}
class ConstTopicType
{
    const ItemTalk = 1;
    const CityTalk = 2;
    const GlobalTalk = 3;
}
class ConstUserTypes
{
    const Admin = 1;
    const User = 2;
    const Merchant = 3;
}
class ConstUserIds
{
    const Admin = 1;
}
class ConstAttachment
{
    const Page = 2;
    const UserAvatar = 1;
    const City = 4;
    const Item = 0;
	const Merchant= 2;
	const AffiliateWidgetSize = 3;
}
class ConstFriendRequestStatus
{
    const Pending = 1;
    const Approved = 2;
    const Reject = 3;
}
class ConstMoreAction
{
    const Inactive = 1;
    const Active = 2;
    const Delete = 3;
    const OpenID = 4;
    const Export = 5;
    const EnableMerchantProfile = 6;
    const Used = 7;
    const DisableMerchantProfile = 8;
    const Online = 9;
    const Offline = 10;
    const FaceBook = 11;
    const DeductAmountFromWallet = 12;
    const NotUsed = 13;
    const UnSubscripe = 14;
    const Checked = 15;
    const Unchecked = 16;
    const Approved = 17;
    const Disapproved = 18;
    const Yahoo = 19;
    const Gmail = 20;
    const Twitter = 21;
    const Suspend = 22;
	const Unsuspend = 23;
	const Flagged = 24;
	const Unflagged = 25;
	const Displayhome = 26;
	const NotDisplayhome = 27;
	const Foursquare = 28;
	const TestMode = 29;
	const MassPay = 30;
	const ItemPurchase = 31;
	const Wallet = 32;
	const Enabled = 33;
	const PayToCharity = 34;
	const AffiliateUser = 35;
}
class ConstMessageFolder
{
    const Inbox = 1;
    const SentMail = 2;
    const Drafts = 3;
    const Spam = 4;
    const Trash = 5;
}
class ConstUserFriendStatus
{
    const Pending = 1;
    const Approved = 2;
    const Rejected = 3;
}
// setting for one way and two way friendships
class ConstUserFriendType
{
    const IsTwoWay = true;
}
// Banned ips types
class ConstBannedTypes
{
    const SingleIPOrHostName = 1;
    const IPRange = 2;
    const RefererBlock = 3;
}
// Banned ips durations
class ConstBannedDurations
{
    const Permanent = 1;
    const Days = 2;
    const Weeks = 3;
}
class ConstReferralRule
{
    const Referral = 1;
    const Referred = 2;
    const BuyedFirst = 3;
    const BuyedSecond = 4;
}
class ConstWithdrawalMassPayGateWays
{
	const PayPal = 23;				//2 is approved id 3 is gateway id
	const PagSeguro = 25;			//2 is approved id 3 is gateway id
	const CharityPayPal = 43;		//4 is approved id 3 is gateway id
	const CharityPagSeguro = 45;	//4 is approved id 3 is gateway id
}
class ConstWithdrawalStatus
{
    const Pending = 1;
    const Approved = 2;
    const Rejected = 3;
    const Failed = 4;
    const Success = 5;
}
class ConstAffiliateCashWithdrawalStatus
{
    const Pending = 1;
    const Approved = 2;
    const Rejected = 3;
    const Failed = 5;
    const Success = 4;
}
class ConstCommsisionType
{
   const Amount = 'amount';
   const Percentage = 'percentage';
}

class ConstAffiliateStatus
{
   const Pending = 1;
   const Canceled = 2;
   const PipeLine = 3;
   const Completed = 4;
}
class ConstAffiliateCommissionType
{
   const Percentage = 1;
   const Amount = 2;
}
class ConstAffiliateRequests
{
   const Pending = 0;
   const Accepted = 1;
   const Rejected = 2;
}
class ConstMyGiftStatus
{
    const Pending = 'Pending';
    const Success = 'Not Yet Redeemed';
    const ToCredit = 'Redeemed By Recipient';
}
class ConstReferralOption
{
    const GrouponLikeRefer = "Refer and Get Amount";
    const XRefer = "Refer and Get Refund/Get Amount";
    const Disabled = "Disable Referral";
}
class ConstReferralCommissionType
{
    const GrouponLikeRefer = 1;
    const XRefer = 2;
}
class ConstReferralRefundType
{
    const RefundItemAmount = "Refund Item Amount";
    const RefundParticularAmount = "Refund Particular Amount";
}
class ConstTransactionTypes
{
    const AddedToWallet = 1;
    const BuyItem = 2;
    const ItemGift = 3;
    const GiftSent = 4;
    const GiftReceived = 5;
    const ReferralAmount = 6;
    const PaidItemAmountToMerchant = 7;
    const UserCashWithdrawalAmount = 8;
    const ItemBoughtRefund = 9;
    const ItemGiftRefund = 10;
    const ReferralAmountPaid = 11;
    const ReceivedItemPurchasedAmount = 12;
    const AcceptCashWithdrawRequest = 13;
    const DeductedAmountForOfflineMerchant = 14;
    const ItemBoughtCancel = 15;
    const ItemGiftCancel = 16;
    const UserWithdrawalRequest = 17;
    const AdminApprovedWithdrawalRequest = 18;
    const AdminRejecetedWithdrawalRequest = 19;
    const FailedWithdrawalRequest = 20;
    const AmountRefundedForRejectedWithdrawalRequest = 21;
    const AmountApprovedForUserCashWithdrawalRequest = 22;
    const FailedWithdrawalRequestRefundToUser = 24;
	const AddFundToWallet = 25;
	const DeductFundFromWallet = 26;
	const PartallyAmountTakenForItemPurchase = 28;
	const PartallyAmountTakenForGiftPurchase = 29;
	const AffliateUserWithdrawalRequest = 30;
    const AffliateAdminApprovedWithdrawalRequest = 31;
    const AffliateAdminRejecetedWithdrawalRequest = 32;
    const AffliateFailedWithdrawalRequest = 33;
	const AffliateAmountRefundedForRejectedWithdrawalRequest = 34;
    const AffliateAmountApprovedForUserCashWithdrawalRequest = 35;
    const AffliateFailedWithdrawalRequestRefundToUser = 36;
	const AffliateAddFundToAffiliate = 37;
    const AffliateAcceptCashWithdrawRequest = 38;
	const CharityFailedWithdrawalRequest = 40;
	const CharityFailedWithdrawalRequestRefundToUser = 41;
	const CharityAcceptCashWithdrawRequest = 42;
	const CharityAdminApprovedWithdrawalRequest = 43;
    const CharityAdminRejecetedWithdrawalRequest = 44;
    const AmountTakenForCharity = 45;
	const CharityAddFundToCharity = 47;
	const ReferralAddedToWallet = 48;
	const AmountTakenForAffiliate = 49;
	const AmountTakenForAffiliateFromAdmin = 50;
	const AmountTakenForCharityFromAdmin = 51;
}
// Setting for privacy setting
class ConstPrivacySetting
{
    const EveryOne = 1;
    const Users = 2;
    const Friends = 3;
    const Nobody = 4;
}
class ConstPaymentGateways
{
    const Wallet = 1;
    const CreditCard = 2;
    const PayPalAuth = 3;	
    const AuthorizeNet = 4;
	const PagSeguro = 5;
	// affiliate setting 
	const PayPal = 3;
	// mass payment manual
	const ManualPay = 6;
}
class ConstPaymentGatewayFilterOptions
{
    const Active = 1;
    const Inactive = 2;
    const TestMode = 3;
    const LiveMode = 4;
}
class ConstPaymentGatewayMoreActions
{
    const Activate = 1;
    const Deactivate = 2;
    const MakeTestMode = 3;
    const MakeLiveMode = 4;
    const Delete = 5;
}
class ConstCharityWhoWillPay
{
    const Admin = 'Admin';
    const MerchantUser = 'Merchant User';
    const AdminMerchantUser  = 'Admin and Merchant User';
}
class ConstCharityWhoWillChoose
{
    const MerchantUser = 'Merchant User';
    const Buyer = 'Buyer';   
}
class ConstCharityCashWithdrawalStatus
{
    const Pending = 1;
    const Failed = 2;
    const Success = 3;
	const Approved = 4;
	const Rejected = 5;
}
class ConstProfileImage
{
    const Twitter = 1;
	const Facebook = 2;
	const Upload = 3;
}
class ConstCurrencies
{
    const USD = 1;
    const BRL = 24;
}
class ConstModule
{
    const Affiliate = 9;
    const Charity = 8;
    const Friends = 13;
    const Referral = 10;
}
class ConstSettingsSubCategory
{
    const Regional = 24;
    const DateAndTime = 25;
    const Barcode = 35;
	const Commission = 31;
}
class ConstModuleEnableFields
{
	const Commission = 59;
    const Affiliate = 99;
    const Charity = 94;
    const Friends = 122;
    const Referral = 215;
	const Discussion = 217;
}
?>