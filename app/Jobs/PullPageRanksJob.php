<?php

namespace App\Jobs;

use App\Exceptions\DomainsListFileNotFoundException;
use App\Exceptions\OpenPageRankServiceException;
use App\Models\DomainInfo;
use App\Services\DomainListFromRemoteJsonService;
use App\Services\OpenPageRankService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PullPageRanksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @throws DomainsListFileNotFoundException
     * @throws OpenPageRankServiceException
     */
    public function handle(): void
    {
        $domainListService = new DomainListFromRemoteJsonService();
        $rankService = new OpenPageRankService();

        $domains = $domainListService->getDomainList();
        $rank_data = $rankService->getPagesData($domains);

        foreach ($rank_data as $page ) {
            $domainInfo = DomainInfo::where('name', $page->domain)->first();
            if(!$domainInfo) {
                $domainInfo = new DomainInfo();
            }
            $domainInfo->name = $page->domain;
            $domainInfo->rank = $page->rank;
            $domainInfo->save();
        }
    }
}
