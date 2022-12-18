<div class="blockLicense">
    <if:[param44]=='Y'>
        <div class="license-item">
            <label>
                <input type="checkbox" name="personal_accepted" {$personal_checked} required>
                [param45]
            </label>
        </div>
    </if>
    <if:[param46]=='Y'>
        <div class="license-item">
            <label>
                <input type="checkbox" name="additional_accepted" {$additional_checked} required>
                [param47]
            </label>
        </div>
    </if>
</div>
