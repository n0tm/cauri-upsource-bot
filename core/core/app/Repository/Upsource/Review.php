<?php

namespace App\Repository\Upsource;

use App\Domain\Contract;
use App\Repository\AbstractRepository;
use Illuminate\Database\Eloquent\Model;
use \App\Model\Upsource\Review as ReviewModel;

class Review extends AbstractRepository implements Contract\Repository\Upsource\Review
{
    public function create(string $id, string $creatorId, string $branch): bool
    {
        $review = $this->getModel();

        $review->setAttribute(ReviewModel::COLUMN_NAME_ID, $id);
        $review->setAttribute(ReviewModel::COLUMN_NAME_CREATOR_UPSOURCE_USER_ID, $creatorId);
        $review->setAttribute(ReviewModel::COLUMN_NAME_BRANCH, $branch);

        return $review->save();
    }

    public function getById(string $id): ?Contract\Entity\Upsource\Review
    {
	    /** @var Contract\Record\Upsource\Review $record */
        $record = $this->getModel()
	        ->newQuery()
	        ->find($id);

	    return $record === null ? null : $record->getEntity();
    }

	/**
	 * @return ReviewModel
	 */
	protected function getModel(): Model
	{
		return new ReviewModel();
	}
}