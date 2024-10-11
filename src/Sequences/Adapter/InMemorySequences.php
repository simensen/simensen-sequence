<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequences\Adapter;

use Simensen\Sequence\Sequences\CurrentValueManagement;
use Simensen\Sequence\Sequences\Sequences;

interface InMemorySequences extends Sequences, CurrentValueManagement
{
}
