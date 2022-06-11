<?php
namespace App\Http\Traits;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait Scopes {

        // scope month
        public function scopeMonth($query){
            return $query->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'));
        }
    
        // scope subMonth
        public function scopeSubMonth($query){
            return $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', date('Y'));
        }
    
        // scope Sub7Days
        public function scopeSub7Days($query){
            return $query->where('created_at', '>=', Carbon::now()->subDays(7));
        }

        // scope day
        public function scopeDay($query){
            return $query->whereDate('created_at', Carbon::today());
        }
    
        // scope CountStatus
        public function scopeCountStatus($query)
        {
            return $query->select(
                DB::raw('COUNT(case when status = 1 then id end) as Active'),
                DB::raw('COUNT(case when status = 2 then id end) as Suspend'),
                DB::raw('COUNT(case when status = 0 then id end) as Blocked'),
            );
        } 
        // scope CountRoles
        public function scopeCountRoles($query)
        {
            return $query->select(
                DB::raw('COUNT(case when role = 0 then id end) as Admin'),
                DB::raw('COUNT(case when role = 1 then id end) as Moderator'),
                DB::raw('COUNT(case when role = 2 then id end) as User'),
            );
        } 
        // scope CountCompleted
        public function scopeCountCompleted($query)
        {
            return $query->select(
                DB::raw('COUNT(id) as total'),
                DB::raw('COUNT(case when complete_at IS NOT NULL then id end) as completed'),
                DB::raw('COUNT(case when complete_at IS NULL then id end) as `non completed`'),
            );
        } 
        // scope DateAnalyses
        public function scopeDateAnalyses($query)
        {
            return $query->select(
                DB::raw('COUNT(case when DATE(created_at) =  CURDATE() then id end) as today'),
                DB::raw('COUNT(case when DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) then id end)   as yesterday'),
                DB::raw('COUNT(case when DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) then id end)   as last_7_days'),
                DB::raw('COUNT(case when DATE(created_at) =  DATE_SUB(CURDATE(), INTERVAL 1 MONTH) then id end) as last_month'),
                DB::raw('COUNT(case when DATE(created_at) =  DATE_SUB(CURDATE(), INTERVAL 3 MONTH) then id end) as last_quarter'),
            );
        }
        public function scopeCompleted($query)
        {
            return $query->whereNotNull('complete_at');
        }
        public function scopeNotCompleted($query)
        {
            return $query->whereNull('complete_at');
        }
        public function scopeAdmin($query)
        {
            return $query->where('role', 0);
        }

        public function scopeUser($query)
        {
            return $query->where('role', 2);
        }

        public function scopeVisible($query)
        {
            return $query->where('hidden', false);
        }
    
        public function scopeHidden($query)
        {
            return $query->where('hidden', true);
        }
    
        public function scopeActive($query)
        {
            return $query->where('status', true);
        }
    
        public function scopeUnActive($query)
        {
            return $query->where('status', false);
        }
    
        public function scopeIsTrused($query)
        {
            return $query->where('is_trusted', true);
        }
    
        public function scopeOnlyDeleted($query)
        {
            return $query->onlyTrashed();
        }
    
        public function scopeWithDeleted($query)
        {
            return $query->withTrashed();
        }
    
        public function scopeUnexpired($query)
        {
            return $query->where('end_at', '>', date('Y-m-d'));
        }
    
        public function scopeExpired($query)
        {
            return $query->where('end_at', '<', date('Y-m-d'));
        }
    
        public function scopeStarted($query)
        {
            return $query->where('start_at', '<=', date('Y-m-d'));
        }
    
        public function scopeSuccessPayment($query)
        {
            return $query->where('success_status', 1);
        }
    
        public function scopeFailedOrderStatus($query)
        {
            return $query->where('failed_status', 1);
        }
}