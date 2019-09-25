<div class="card green-bg card-one clickable" onclick="window.location.href='/bedrijf'">
    <div class="card-body">
        <div class="card-title h-50">
            <img class="ml-3 mt-3 w-50" src="/resources/assets/images/company_text.svg"
                 alt="<?= \App\model\translation\Translation::get('call_to_action_bedrijf_foto_alt_tekst') ?>">
        </div>

        <div class="card-text">
            <p>
                <?= \App\model\translation\Translation::get('call_to_action_bedrijf_tekst') ?>
            </p>
        </div>

        <button class="green-text" onclick="window.location.href='/bedrijf'">
            <?= \App\model\translation\Translation::get('call_to_action_bedrijf_knop_tekst') ?>
        </button>
    </div>
</div>

<div class="card gray-bg card-two clickable" onclick="window.location.href='/student'">
    <div class="card-body">
        <div class="card-title h-50">
            <img class="w-50" src="/resources/assets/images/student_text.svg"
                 alt="<?= \App\model\translation\Translation::get('call_to_action_student_foto_alt_tekst') ?>">
        </div>

        <div class="card-text">
            <p>
                <?= \App\model\translation\Translation::get('call_to_action_student_tekst') ?>
            </p>
        </div>

        <button class="gray-text" onclick="window.location.href='/student'">
            <?= \App\model\translation\Translation::get('call_to_action_student_knop_tekst') ?>
        </button>
    </div>
</div>

<div class="card default-bg card-three clickable" onclick="window.location.href='/meet-the-expert'">
    <div class="card-body">
        <div class="card-text">
            <p>
                <?= \App\model\translation\Translation::get('call_to_action_meet_the_expert_tekst') ?>
            </p>
        </div>

        <div class="card-title" onclick="window.location.href='/meet-the-expert'">
            <img class="w-75 image-mobile" src="/resources/assets/images/meet_the_expert_text.svg"
                 alt="<?= \App\model\translation\Translation::get('call_to_action_meet_the_expert_foto_alt_tekst') ?>">
        </div>
    </div>
</div>